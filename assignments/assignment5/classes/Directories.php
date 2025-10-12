<?php
class Directories {
    private $basePath = 'directories';

    public function createDirectoryAndFile($dirName, $fileContent) {
        $dirPath = $this->basePath . '/' . $dirName;

        if (file_exists($dirPath)) {
            return [
                'status' => 'error',
                'message' => 'A directory already exists with that name.'
            ];
        }

        if (!mkdir($dirPath, 0777, true)) {
            return [
                'status' => 'error',
                'message' => 'Error: Unable to create directory.'
            ];
        }

        $filePath = $dirPath . '/readme.txt';
        if (file_put_contents($filePath, $fileContent) === false) {
            return [
                'status' => 'error',
                'message' => 'Error: Unable to create file.'
            ];
        }

        return [
            'status' => 'success',
            'path' => $filePath
        ];
    }
}
?>
