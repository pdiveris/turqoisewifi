<?php

namespace App;

class NanoBotRepository
{
    /**
     * @var Persistence
     */
    private $persistence;

    private static $instance = null;

    public function __construct(Persistence $persistence)
    {
        $this->persistence = $persistence;
    }

    public function generateId(): NanoBotId
    {
        return NanoBotId::fromInt($this->persistence->generateId());
    }

    public function findById(NanoBotId $id): NanoBot
    {
        try {
            $arrayData = $this->persistence->retrieve($id->toInt());
        } catch (\OutOfBoundsException $e) {
            throw new \OutOfBoundsException(sprintf('NanoBot with id %d does not exist', $id->toInt()), 0, $e);
        }

        return NanoBot::fromState($arrayData);
    }

    public function save(NanoBot $nanoBot)
    {
        $this->persistence->persist([
            'id' => $nanoBot->getId()->toInt(),
            'xPos' => $nanoBot->getXPos(),
            'yPos' => $nanoBot->getYPos(),
            'zPos' => $nanoBot->getZPos(),
            'range' => $nanoBot->getRange(),
        ]);
    }

    public static function resetInstance()
    {
        self::$instance = null;
    }

    /**
     * Load NanoBot data from file.
     * Please see readme.md for specifics on format and other comments.
     *
     * It expects a single entry to have the following form:
     *  pos=<93382267,11479664,36445998>, r=50796692
     *
     * If not an exception is thrown and the application terminates
     *
     * @param string $path
     * @param Persistence $persistence
     * @return NanoBotRepository
     */
    public static function loadFromFile(string $path, Persistence $persistence): NanoBotRepository
    {
        if (null === self::$instance) {
            self::$instance = new NanoBotRepository($persistence);
        }
        $stream = '';
        try {
            $stream = file_get_contents($path);
        } catch (\Exception $e) {
            abort(521, "Invalid path specified. Cannot open the data file $path");
        }

        $recs = explode("\n", $stream);

        foreach ($recs as $rec) {
            if ($rec !== '') {
                if (preg_match('/pos=<(.*),(.*),(.*)>,\sr=([-+]?\d*)$/', $rec, $out)) {
                    try {
                        if (count($out) == 5) {
                            $id = NanoBotId::fromInt($persistence->generateId());
                            $nano = new NanoBot($id, $out[1], $out[2], $out[3], $out[4]);
                            $persistence->persist(self::toArray($nano));
                        } else {
                            throw new InvalidDataFileEntryException(
                                'Invalid entry in data file. Please consult the readme.MD file for tips and info.'
                            );
                        }
                    } catch (InvalidDataFileEntryException $e) {
                        abort('522');
                    }
                }
            }
        }
        return self::$instance;
    }

    public static function toArray(NanoBot $nanoBot): array
    {
        return [
            'id'=>$nanoBot->getId(),
            'xPos'=>$nanoBot->getXPos(),
            'yPos'=>$nanoBot->getYPos(),
            'zPos'=>$nanoBot->getZPos(),
            'range'=>$nanoBot->getRange(),
        ];
    }

    /**
     * Sort descending
     *
     * @param $a
     * @param $b
     * @return int
     */
    public function cmp($a, $b)
    {
        if ($a['range'] == $b['range']) {
            return 0;
        }
        return ($a['range'] < $b['range']) ? 1 : -1;
    }


    /**
     * @return array
     */
    public function all()
    {
        return $this->persistence->all();
    }

    /**
     * Find the top nanobot, i.e. the one with the longest reach.
     * Please consult the readme.md file for more details
     * In a production system the sorted version would be cached for consecutive calls
     * however, no further calls are expected in this instance
     *
     * @return mixed
     * @throws \Exception
     */
    public function findTopNanoBot()
    {
        $data = $this->all();

        try {
            if (count($data) < 1) {
                throw new \Exception(
                    'Empty data passed, aborting..'
                );
            }
        } catch (\Exception $e) {
            abort(521, 'Empty data passed, aborting..');
        }
        usort($data, [$this, 'cmp']);

        $nano = $this->findById($data[0]['id']);
        return $nano;
    }
}
