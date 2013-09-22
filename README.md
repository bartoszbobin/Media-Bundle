Media-Bundle
============
Easy way to generate new media with specified size, totally `out of the box`.

#### Example:
At the frontend layer when we want to display our user image with dimensions (w: 120, h: 90) based on orginal size (1920x1080), user will wait too long.

Instead of uploading new resized image, we can specified for already existing image, new size - and new file will be generated.

Big adventage of this solution is that image with new size will be lazy loaded after first request - so we will not lose disk space if this file is not really needed.
We can also delete all generated files and also save disk space.

oryginal file

      /static/oryg/*    <-- here we will have all our media files

Example request:

      /static/oryg/header-symfony-logo.png

-- new sizes

      /static/200x100/header-symfony-logo.png
      /static/120x50/header-symfony-logo.png

When we want to have new image with saving ratio scale:

      /static/0x100/header-symfony-logo.png  // width will by auto resized
      /static/100x0/header-symfony-logo.png  // height will by auto resized




## Configuration
#### routing.yml

    static_file:
        pattern:  /static/{size}/{fileName}
        defaults:
          _controller: BobinMediaBundle:File:generate
          namespace: static
          directory: 
        methods:  [GET]
        requirements:
            size:  ^[0-9]{1,5}x[0-9]{1,5}$
    
    gallery_file:
        pattern:  /gallery/{directory}/{size}/{fileName}
        defaults:
          _controller: BobinMediaBundle:File:generate
          namespace: gallery
        methods:  [GET]
        requirements:
            size:  ^[0-9]{1,5}x[0-9]{1,5}$
            directory: ^gal_([0-9]{5})$
        
        
#### config.yml

      bobin_media:
          static:
             path: /var/www/static/
             sizes:
               - { width: 800, height: 600 }
               - { width: 0, height: 600, fit_big_to_size: true }
               - { width: 400, height: 400, fit_big_to_size: true, resize_small_to_size: false }
          gallery:
            path: /var/www/gallery/
            sizes:
              - { width: 800, height: 600 }
