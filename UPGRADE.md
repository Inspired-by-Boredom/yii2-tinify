Upgrading Instructions
======================

This file contains the upgrade notes. These notes highlight changes that could break your
application when you upgrade the package from one version to another.

Upgrade from 1.0.0 to 2.0.0
---------------------------

* `vintage\tinify\commands\TinifyController` has been moved to
`vintage\tinify\cli\TinifyController` namespace. Check and replace `vintage\tinify\commands` to
`vintage\tinify\cli`.
