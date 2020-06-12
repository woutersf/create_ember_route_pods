<?php

/**
 * Remove folders that are empty recursively.
 */
function RemoveEmptySubFolders($path) {
  $empty = TRUE;
  foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
    if (is_dir($file)) {
      if (!RemoveEmptySubFolders($file)) {
        $empty = FALSE;
      }
    }
    else {
      $empty = FALSE;
    }
  }
  if ($empty) {
    rmdir($path);
  }
  return $empty;
}

/**
 * From js file create pod name.
 */
function podNameFromFile($name) {
  $name = str_replace('.hbs', '', $name);
  $podName = str_replace('.js', '', $name);
  return $podName;
}

/**
 * Recursive function that moves blabla.js to blabla/route.js.
 */
function rec_move_folder_files($depth, $path, $targetpath, $jsFileName, $skipDashes) {
  $depth = $depth + 1;
  $files = scandir($path);
  foreach ($files as $fileOrFolder) {

    // Skip these.
    if ($fileOrFolder == '.' || $fileOrFolder == '..' || $fileOrFolder == '.gitkeep') {
      continue;
    }

    // Skip templates with dashes.
    if (strpos($fileOrFolder, '-') > 0) {
      continue;
    }

    // Does the poD exist?
    $podName = podNameFromFile($fileOrFolder);
    $podUrl = $targetpath . '/' . $podName;

    // Pod does not exist yet?
    if (!file_exists($podUrl)) {

      // Create folder if no JS file.
      if (strpos($podUrl, 'js') || strpos($podUrl, 'hbs')) {

      }
      else {
        mkdir($podUrl);
      }

    }

    $item_path = $path . '/' . $fileOrFolder;

    if (is_dir($item_path)) {
      // If Folder: recurse into it.
      rec_move_folder_files($depth, $item_path, $podUrl, $jsFileName, $skipDashes);
    }
    else {
      // If file: move to POD.
      rename($item_path, $podUrl . '/' . $jsFileName);
    }
  }
}

// Move routes.
RemoveEmptySubFolders(getcwd() . '/app');
$targetpath = getcwd() . '/app';
$path = getcwd() . '/app/routes';

$files = scandir($path);
foreach ($files as $fileOrFolder) {
  rec_move_folder_files(0, $path, $targetpath, 'route.js', FALSE);
}

// Move controllers.
$targetpath = getcwd() . '/app';
$path = getcwd() . '/app/controllers';
$files = scandir($path);
foreach ($files as $fileOrFolder) {
  rec_move_folder_files(0, $path, $targetpath, 'controller.js', FALSE);
}

// Move templates.
$targetpath = getcwd() . '/app';
$path = getcwd() . '/app/templates';
$files = scandir($path);
foreach ($files as $fileOrFolder) {
  rec_move_folder_files(0, $path, $targetpath, 'template.hbs', TRUE);
}
