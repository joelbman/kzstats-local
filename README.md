# KZStats-Local

This is the local version of my [KZStats (global)](https://github.com/joelbman/kzstats/) software.
It's designed to be used by CS:GO KZ server owners.

The instructions in this README are for setting up the development environment.
If you aren't looking to build the software yourself, please visit the documentation found here: (coming soon)

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

I couldn't get the frontend unit tests running on Windows.
Building contextify seems to be very problematic, so I recommend using a *nix system for running the frontend tests. 

## Credits

* [riku](https://github.com/rikukissa/) - Setting up the mocha testing environment among other frontend help.

## License

MIT