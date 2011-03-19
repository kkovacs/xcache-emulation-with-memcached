<?
/**
 * memcache.php - part of the MNBG project
 * 
 * The purpose of this file is to provide xcache functions, but using memcached.
 * 
 * If XCache is already installed, or if the memcached server is not running,
 * then this code should still not cause problems.
 *
 * It connects to the memcached server only when it's actually about to be used.
 */
$memcache_host = 'xxx.xxx.xxx.xxx';
$memcache_port = 11211;

if (!function_exists('xcache_get')) {
	function cache_connect() {
		global $memcache_object, $cache_connected, $memcache_port, $memcache_host;
		// We are ok if it's already connected
		if ($cache_connected)
			return true;
		// We are NOT ok if we already tried, but it's NOT connected
		if ($memcache_object && !$cache_connected)
			return false;
		// Try to connect
		$memcache_object = new Memcache;
		$cache_connected = $memcache_object->pconnect($memcache_host, $memcache_port);
		return $cache_connected;
	}

	function xcache_set($id, $data, $timeout) {
		global $memcache_object;
		if (cache_connect()) {
			return $memcache_object->set($id, $data, 0, $timeout);
		} else {
			return false;
		}
	}

	function xcache_get($id) {
		global $memcache_object;
		if (cache_connect()) {
			return $memcache_object->get($id);
		} else {
			return false;
		}
	}

	function xcache_unset($id) {
		global $memcache_object;
		if (cache_connect()) {
			return $memcache_object->delete($id, 0);
		} else {
			return false;
		}
	}
}

// FOR TESTING, UNCOMMENT:
/*
echo "DEBUG:\n";
var_dump($cache_connected);

if (isset($_REQUEST['unset'])) {
        echo "unset:\n";
        var_dump( xcache_unset('counter') );
}

echo "get:\n";
var_dump( xcache_get('counter') );

echo "set:\n";
var_dump( xcache_set('counter', xcache_get('counter') + 1, 30) );
*/
