<?php
class ZJson implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }

    public function SerializeObject()
    {
    	return json_encode($this,JSON_UNESCAPED_UNICODE);
    }
}