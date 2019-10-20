<?php
class VideoDetailsFormProvider {

    public function createUploadForm() {
        $fileInput = $this->createFileInput();
        return "<form action='processing.php' method='POST'>
                    $fileInput
                </form>";
    }

    private function createFileInput() {

        return "<div class='form-group'>
                    <input type='file' class='form-control-file' id='exampleFormControlFile1' required>
                 </div>";

    }
}

?>