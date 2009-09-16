<?php
class Transcoder {
    public $id = null;
    public $name = '';
    private static $instances = array();

    public static function &find($id = 0) {
        if (!isset(self::$instances[$id]))
            self::$instances[$id] = new self($id);
        return self::$instances[$id];
    }

    public static function  findAll() {
        global $db;
        return $db->query('SELECT 0
                            UNION
                           SELECT recordingprofiles.id
                             FROM recordingprofiles
                             JOIN profilegroups
                               ON recordingprofiles.profilegroup  = profilegroups.id
                            WHERE cardtype                        = "TRANSCODE"
                              AND recordingprofiles.name         != "RTjpeg/MPEG4"
                              AND recordingprofiles.name         != "MPEG2"')->fetch_cols();

    }

    public function __construct($id = 0) {
        global $db;

        $this->id = $id;
        if ($id == 0)
            $this->name = 'Autodetect';
        else
            $this->name = $db->query_col('SELECT recordingprofiles.name
                                            FROM recordingprofiles
                                           WHERE recordingprofiles.id = ?',
                                         $id
                                         );
        if (is_null($this->name))
            $this->name = '&nbsp;';
    }

    public function __toString() {
        return $this->name;
    }
}
