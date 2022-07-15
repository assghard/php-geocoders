<?php

declare(strict_types=1);

namespace Assghard\PhpGeocoders\Providers;

class HttpProvider {

    /**
     * @var string
     */
    private $geocoderUrl;

    /**
     * @var array
     */
    private $config;

	public function __construct($geocoderUrl, $config = [])
	{
        $this->geocoderUrl = $geocoderUrl;
        $this->config = $config;
	}

    public function getRequest(string $uri = '', array $params = [])
    {
        $requestUrl = $this->geocoderUrl;
        if (!empty($uri)) {
            $requestUrl .= '/'.$uri;
        }

        if (!empty($params)) {
            $requestUrl .= '?'.http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, get_random_user_agent());
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        try {
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (empty($result)) {
                return false;
            }

            if ($httpcode != 200) {
                return false;
            }

            return json_decode($result, true);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
