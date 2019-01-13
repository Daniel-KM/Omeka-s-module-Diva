Diva Viewer (module for Omeka S)
================================

[Diva Viewer] is a module for [Omeka S] that integrates [Diva], a Document Image
Viewer with AJAX, that is an advanced online viewer for images, so it can
display books, images, maps, etc. via the [IIIF] standard.

[Diva] is a web-based document viewer optimized for high-resolution image
collections. Using Diva you can display your images at the largest resolution.
It has a full API and plugin system to help integrate and extend Diva to suit
your needs.

It uses the resources of any [IIIF] compliant server. The full specification of
the "International Image Interoperability Framework" standard is supported
(level 2). If you don’t have an [IIPImage] server, Omeka S can be one! Just
install the module [IIIF Server].

It is an alternative to the [Universal Viewer] or the [Mirador Viewer].

Note: unlike Universal Viewer and Mirador, Diva uses always the tiles. So if you
use the module IIIF server as image server, all images should be tiled first,
else the display of images may be slow.


Installation
------------

The module uses an external js library [Diva], so use the release zip to
install it, or use and init the source.

* From the zip

Download the last release [`Diva.zip`] from the list of releases (the
master does not contain the dependency), and uncompress it in the `modules`
directory.

* From the source and for development:

If the module was installed from the source, rename the name of the folder of
the module to `Diva`, and go to the root module, and run:

```
    npm install
    gulp install
```

The next times:

```
    npm update
    gulp update
```

* Configuration

Then install it like any other Omeka module.

If you don’t have an IIIF Server, install the module [IIIF Server].

If you need to display big images (bigger than 1 to 10 MB according to your
server and your network), use an external image server, or create tiles with [IIIF Server].
The tiling means that big images like maps and deep paintings, and any other
images, are converted into tiles in order to load and zoom them instantly.

Only one option can be set in the main config (the manifest property, if any).
The other can be set differently for each site, in the site settings:

- in site settings for the integration of the player;
- via the theme of the site: copy file `view/common/helper/diva.phtml` in your
  theme and customize it;
- via the theme of the site and the assets (`asset/vendor/diva).

See below the notes for more info.


Usage
-----

If the [IIIF Server] is installed, all resources of Omeka S are automatically
available by Diva.

The viewer is always available at `http://www.example.com/item-set/{item-set id}/diva`
and `http://www.example.com/item/{item id}/diva`. Furthermore, it is
automatically embedded in "item-set/{id}" and "item/{id}" show and/or browse
pages. This can be disabled in the settings of the site. Finally, a block layout
is available to add the viewer in any standard page.

To embed Diva somewhere else, just use the helper:

```php
    // Display the viewer with the specified item set.
    echo $this->diva($itemSet);

    // Display the viewer with the specified item and specified options.
    echo $this->diva($item, array(
        'class' => 'my-class',
        'style' => 'width: 40%; height: 400px;',
    ));

    // Display multiple resources (items and/or item sets).
    echo $this->diva($resources);
```


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [module issues] page on GitHub.


License
-------

This module is published under the [CeCILL v2.1] licence, compatible with
[GNU/GPL] and approved by [FSF] and [OSI].

In consideration of access to the source code and the rights to copy, modify and
redistribute granted by the license, users are provided only with a limited
warranty and the software’s author, the holder of the economic rights, and the
successive licensors only have limited liability.

In this respect, the risks associated with loading, using, modifying and/or
developing or reproducing the software by the user are brought to the user’s
attention, given its Free Software status, which may make it complicated to use,
with the result that its use is reserved for developers and experienced
professionals having in-depth computer knowledge. Users are therefore encouraged
to load and test the suitability of the software as regards their requirements
in conditions enabling the security of their systems and/or data to be ensured
and, more generally, to use and operate it in the same conditions of security.
This Agreement may be freely reproduced and published, provided it is not
altered, and that no provisions are either added or removed herefrom.

[Diva] is published under the [ISC] licence.


Copyright
---------

Widget [Diva]:

* See https://ddmal.github.io/diva.js/about

Module Diva for Omeka S:

* Copyright Daniel Berthereau, 2018-2019

First version of this module was built for the University of California.


[Diva Viewer]: https://github.com/Daniel-KM/Omeka-S-module-Diva
[Diva]: https://ddmal.github.io/diva.js
[Omeka S]: https://omeka.org/s
[Omeka]: https://omeka.org
[IIIF Server]: https://github.com/Daniel-KM/Omeka-S-module-IiifServer
[IIIF]: http://iiif.io
[IIPImage]: http://iipimage.sourceforge.net
[Universal Viewer]: https://github.com/Daniel-KM/Omeka-S-module-UniversalViewer
[Mirador Viewer]: https://github.com/Daniel-KM/Omeka-S-module-Mirador
[`Diva.zip`]: https://github.com/Daniel-KM/Omeka-S-module-Diva/releases
[iiif specifications]: http://iiif.io/api/
[module issues]: https://github.com/Daniel-KM/Omeka-S-module-Diva/issues
[CeCILL v2.1]: https://www.cecill.info/licences/Licence_CeCILL_V2.1-en.html
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[FSF]: https://www.fsf.org
[OSI]: http://opensource.org
[ISC]: https://www.isc.org/downloads/software-support-policy/isc-license/
[Daniel-KM]: https://github.com/Daniel-KM "Daniel Berthereau"
