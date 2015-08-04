# KZStats-Local

- [Homepage](http://www.kzstats.com/local/)
- [Demo](http://www.kzstats.com/local/demo/)

This is the local version of my [KZStats (global)](https://github.com/joelbman/kzstats/) software.
It's designed to be used by CS:GO KZ server owners.

The instructions in this README are for setting up the development environment.
If you aren't looking to build the software yourself, please visit this [page](https://www.kzstats.com/local/).

## Prerequisities

* [Node.js](https://nodejs.org/)
* [Composer](https://getcomposer.org/)

## Installation

``` npm install ```

This should install the required packages for node, bower and composer.

## Usage

Start the watch/build cycle:

``` npm start ```

Build with minification:

```
export NODE_ENV=production
npm run build
```

Run tests:
```
npm run phpunit
npm run mocha
```

## Known issues

Dev packages might not install correctly on Windows.
This is due to some C++ compiling thing going of with the contextify package.
You need to have Python 2.x folder in your PATH env variable and Visual C++ 2010 or later. (and it still might not work)
I recommend using a *nix system for building/testing.

## Bug reports & suggestions
For bugs you can file an issue on Github. You can also alternatively contact me by adding me on [Steam](http://steamcommunity.com/id/so0le/).

## Credits

* [riku](https://github.com/rikukissa/) - Setting up the mocha testing environment among other frontend help.
* [versaceLORD](http://www.climblounge.com/) - Providing sample data from climbLOUNGE servers for testing and demo.

## License

MIT