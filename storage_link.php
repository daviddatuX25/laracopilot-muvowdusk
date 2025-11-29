<?php
// storage_link.php
symlink(__DIR__.'/storage/app/public', __DIR__.'/public/storage');
echo 'Storage link created!';
