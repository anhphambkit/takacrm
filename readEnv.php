<?php 

class readEnv 
{
    /**
     * @var array 
     */
    private $envData = array();

    /**
     * Get env data by key
     * @param type|null $key 
     * @return type
     */
    public function getEnv($key = null)
    {
        if(empty($key))
            return $this->envData;

        if(!empty($this->envData[$key]))
            return $this->envData[$key];
    }

    /**
     * set value
     * @param array|array $array 
     * @return type
     */
    public function setEnv(array $array = [])
    {
        return $this->envData = $array;
    }

    /**
     * Convert env file to array
     * @param type|string $path 
     * @return type
     */
    public function convertEnv($path = '.env')
    {
    	if(!$this->checkExistFile($path))
    		throw new \Exception("Invalid .env file config", 1);
    		
        $env  = file_get_contents($path);
        $envs = preg_split('/\r\n|\r|\n/', $env);
        $env  = array();
        foreach ($envs as $e){
            if(!empty($e) && $e = trim($e)){
                if(substr($e,0,1) === '#'){
                    continue;
                }
                $regex = '/([\w|\d|]*)=(.*)/';
                preg_match_all($regex, $e, $matches, PREG_SET_ORDER, 0);
                $matches[0][2] = empty($matches[0][2]) || $matches[0][2] === 'null' ? null : $matches[0][2];
                $matches[0][2] = $matches[0][2] === 'true' ? true : $matches[0][2];
                $matches[0][2] = $matches[0][2] === 'false' ? false : $matches[0][2];
                if(!empty($matches[0][1])){
                    $env[$matches[0][1]] = $matches[0][2];
                }
            }
        }
        return $this->setEnv($env);
    }

    /**
     * Validate file exists
     * @param type $filePath 
     * @return type
     */
    protected function checkExistFile($filePath)
    {
    	if(file_exists($filePath))
    		return true;                 
    }
}