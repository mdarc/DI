# mdarc/DI

This is a set of performance comparisons between mdarc/DI, [Pimple](https://pimple.symfony.com/) and [PHP-DI](http://php-di.org).

These tests were executed in the following environment:

|   |   |
|---|---|
|OS        | Ubuntu 19.04 desktop 64-bit    |
|PHP       | PHP 7.3.9-1+ubuntu19.04.1+deb.sury.org+1 (cli) (built: Sep  2 2019 12:54:43) ( NTS ) |
|Processor | Intel® Core™ i7-8550U CPU @ 1.80GHz × 8 |
|Memory    | 15,5 GiB |


## Benchmark results ##

The first benchmark is about the time it take just to create a new instance of the Container
class without any configuration.
```
$ php benchmark1.php

--------------- Start compare: Class Instantiation ---------------
Running tests 100000 times
PHP Overhead: time=173 ms; memory=47.95 KB;

Testing 1/3 : pimple ... Done!
Testing 2/3 : php-di ... Done!
Testing 3/3 : mdarc/DI ... Done!

Name of test        Time    Time one    Time, %    Memory leak    Memory, %    
mdarc/DI          205 ms    0.002 ms        100            0 B          100    
pimple            264 ms    0.003 ms        129            0 B          100    
php-di          1 125 ms    0.011 ms        549      132.79 KB          279    

TOTAL: Time: 1.77 secs; Memory: 601.44 KB
-------------------- Finish compare: Class Instantiation ---------
```

The following benchmark is instantiation of the Container, simple configuration and fetching
one object from it (no autowiring) for the first time. 
```
$ php benchmark2.php

--------------- Start compare: Fetch an instance of simple class without dependencies - First time ---------------
Running tests 100000 times
PHP Overhead: time=191 ms; memory=47.95 KB;

Testing 1/4 : pimple ... Done!
Testing 2/4 : php-di ... Done!
Testing 3/4 : php-di (compilation enabled) ... Done!
Testing 4/4 : mdarc/DI ... Done!

Name of test                        Time    Time one    Time, %    Memory leak    Memory, %    
mdarc/DI                          524 ms    0.005 ms        100            0 B          100    
pimple                            682 ms    0.007 ms        130            0 B          100    
php-di (compilation enabled)    5 027 ms    0.050 ms        959      388.40 KB          817    
php-di                          5 508 ms    0.055 ms      1 050      468.38 KB          986    

TOTAL: Time: 11.95 secs; Memory: 4.59 MB
-------------------- Finish compare: Fetch an instance of simple class without dependencies - First time ---------
```

The following benchmark measures the time of an already configured container
and fetching one object from it (no autowiring) for the second time time. 
```
$ php benchmark3.php

--------------- Start compare: Fetch an instance of simple class without dependencies - Second time ---------------
Running tests 1000000 times
PHP Overhead: time=1 627 ms; memory=47.85 KB;

Testing 1/4 : pimple ... Done!
Testing 2/4 : php-di ... Done!
Testing 3/4 : php-di (compilation enabled) ... Done!
Testing 4/4 : mdarc/DI ... Done!

Name of test                        Time    Time one    Time, %    Memory leak    Memory, %    
mdarc/DI                        2 136 ms    0.002 ms        100            0 B          100    
php-di (compilation enabled)    2 172 ms    0.002 ms        102            0 B          100    
php-di                          2 345 ms    0.002 ms        110            0 B          100    
pimple                          2 458 ms    0.002 ms        115            0 B         -100    

TOTAL: Time: 10.73 secs; Memory: 0 B
-------------------- Finish compare: Fetch an instance of simple class without dependencies - Second time ---------
```

The following benchmark measures the time that PHP-DI and mdarc/DI
take for fetching an object for the first time using autowiring (Reflection) 
```
$ php benchmark4.php

--------------- Start compare: Autowiring - Fetch an instance of simple class without dependencies - First time ---------------
Running tests 100000 times
PHP Overhead: time=181 ms; memory=47.95 KB;

Testing 1/2 : php-di (development mode) ... Done!
Testing 2/2 : mdarc/DI ... Done!

Name of test                     Time    Time one    Time, %    Memory leak    Memory, %    
mdarc/DI                       500 ms    0.005 ms        100            0 B          100    
php-di (development mode)    3 689 ms    0.037 ms        738      247.67 KB          521    

TOTAL: Time: 4.37 secs; Memory: 642.68 KB
-------------------- Finish compare: Autowiring - Fetch an instance of simple class without dependencies - First time ---------
```

The following benchmark measures the time that mdarc/DI
takes for fetching an object for the first time by using a definition vs. autowiring (Reflection).
 
```
$ php benchmark5.php

--------------- Start compare: Defined class vs. Autowiring ---------------
Running tests 100000 times
PHP Overhead: time=172 ms; memory=47.95 KB;

Testing 1/2 : mdarc/DI (class defined in constructor) ... Done!
Testing 2/2 : mdarc/DI (autowiring - aka Reflection) ... Done!

Name of test                                  Time    Time one    Time, %    Memory leak    Memory, %    
mdarc/DI (autowiring - aka Reflection)     451 ms    0.005 ms        100            0 B          100    
mdarc/DI (class defined in constructor)    488 ms    0.005 ms        108            0 B         -100    

TOTAL: Time: 1.11 secs; Memory: 168.45 KB
-------------------- Finish compare: Defined class vs. Autowiring ---------
```
*Interestingly enough in this previous test we see that using Reflection is a bit faster than not using it at all.*
*This peculiarity is due to optimizations in the PHP 7 runtime.*

#### Are these tests wrongly setup or not reflecting the correct numbers? ####
Please, help us by contributing a **pull request**
