## Fracture PHP Framework

Fracture is a small web application framework with emphasis on best OOP practices and readability of code.

The purpose of this project is to create a system which provides a clear separation between framework and application with an unambiguous way to replace or extend any part of the framework.


####Current status:

[![Build Status](https://travis-ci.org/fracture/fracture.png?branch=master)](https://travis-ci.org/fracture/fracture)
[![Coverage Status](https://coveralls.io/repos/fracture/fracture/badge.png?branch=master)](https://coveralls.io/r/fracture/fracture?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/fracture/fracture/badges/quality-score.png?s=e4a600d014e69fb051b9fdf5d7fd9536da7a39c2)](https://scrutinizer-ci.com/g/fracture/fracture/)


####Project's goals

 - Implementation for **autoload**, which lets you take advantage of PHP's ability to use case-insensitive class, namespace, trait and interface names. It also has to provide ability to switch between dynamic, configuration-based autoloading *(for "development" stage of project)* and predefined class-map driven approach *(for "production" stage)*, since there are different priorities in each stage.

 - Clearly isolated **routing** of user's requests.The configuration of default router has to be simple, painless and easy to read. It also must easy to replace or extend it.

 - And the data, which user sends, must abstracted in a logical way, when it reaches the application. The developer should not interacting with PHP superglobals and a framework should not be encouraging it.
