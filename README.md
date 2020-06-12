# Podizer
Use this script to move your existing codebase to route POD structure.
This script will recursively go into every folder and try to make a pod out of it.

```sh
$ clone this repository (or copy the raw file contents)
$ copy the file pod-ize.php into your ember project MYEMBERPROJECT
$ cd MYEMBERPROJECT
$ php pod-ize.php
$ rm pod-ize.php
```
Now check your project. IT will still work, controllers and routes will have moved to the respective pods.
Templates without a dash will also have moved to the route pod.

# Template file with-DASHES
Templates with a dash (e.g. mock-login.hbs) will not be moved to the pod folder yet (they dont seem to be picked up there) not sure yet what is going on there.

