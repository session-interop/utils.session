# Array Session

This package is a basic implementation of [`SessionInterface`](https://github.com/session-interop/session-interop)

## Installation

You can install this package through Composer:

```json
composer require session-interop/utils.arraysession
```
The packages adheres to the [SemVer](http://semver.org/) specification, and there will be full backward compatibility between minor versions.

## Available

### [`SessionArray`](src/ArraySession.php).

The implementation of SessionInterface.

#### Methods

###### `__construct(&$array, $prefix = "")`

Construct the object. The object will use $array to store element. It use a reference on $array, so $array will be modified when you use `set($key)`and `remove($key)`.
If prefix is given, it will automatically prefix all `$key`.

###### `has($key)`

Verify is the key `$key` exists into the array injected at the object construction. Throw an exception if the `key` is not a string. if the associated value is `null`, the method return `true`.

###### `get($key)`

Get the value associated with `$key`. Throw an exception if no key are found or if the key is not a string   

###### `set($key, $val)`

Set the value `$val` at the key `$key`. Throw an exception if the key is not a string.

###### `remove($key)`

Destroy the element at `$key`

###  [`SessionException`](src/Exception/SessionException.php).

Exception used on error. Throw an exception if the key is not a string



## Usage

Writing an user service that use the session interface:

UserService.php
```php
namespace Usage;
use Interop\Session\SessionInterface;
class UserService {
      public function isConnected(SessionInterface $session) {
          if ($session->has("userId")) {
	     	   return true;
	        }
	       return false;
      }
      public function login(SessionInterface $session, $userId) {
        if ($this->isConnected($session)) {
          return false;
  	    }
  	    $session->set("userId", $userId);
  	    return true;
      }
      public function logoff(SessionInterface $session) {
        if ($this->isConnected($session)) {
	     	     $session->remove("userId");
		           return true;
	       }
	      return false;
      }
}
```

Use the implementation:

Index.php
```php
use Interop\Session\Utils\ArraySession\ArraySession;
use Usage\UserService;
require_once("vendor/autoload.php");

session_start();

$userId = 1;
$userService = new UserService();
$session = new ArraySession($_SESSION, "myprefix");

// Check if the user is connected

if ($userService->isConnected($session)) {
  // logoff the user
  $userService->logoff($session);
}
else {
  // login the user
  $userService->login($session, $userId);
}
```
