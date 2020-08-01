<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online File Manager</title>
    <link rel="stylesheet" type="text/css" href="file-manager.css">
    <script>
        function _(el){
            return document.querySelector(el);
        }
        function openModal(){
            _('.file-manager-popbox').style.display = 'block';
        }
        function closeModal(){
            _('.file-manager-popbox').style.display = 'none';
        }
        function uploadFile(){
            var file = _("#fl_upload").files[0];
            console.log(file.name+" | "+file.size+" | "+file.type);
            var formdata = new FormData();
            formdata.append("fl_upload", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "upload.php");
            ajax.send(formdata);
        }
        function progressHandler(event){
            _(".process").innerHTML = Math.round(event.loaded / 1024) + 'KB / ' + Math.round(event.total / 1024) + 'KB';
            var percent = (event.loaded / event.total) * 100;
            _(".progressbar").style.width = Math.round(percent) + '%';
            if (Math.round(percent) > 10) {
                _(".tooltip").style.display = "block";
            }
            _(".tooltip").innerHTML = Math.round(percent) + "%";
        }
        function completeHandler(event){
            if (event.target.responseText == 'upload_success') {
                _(".status").innerHTML = 'Uploaded Successfully';
                window.location.reload();
            } else {
                _(".status").innerHTML = 'Upload Fail';
            }
            _(".progressBar").style.width = 0;
        }
        function errorHandler(event){
            _(".status").innerHTML = "Upload Failed";
        }
        function abortHandler(event){
            _(".status").innerHTML = "Upload Aborted";
        }
        _('.file_list').addEventListener('click', function(){
            alert('ok');
        });
    </script>
</head>
<body>
    <div class="file-manager">
        <div class="file-manager-header">
            <h2>Online File Manager</h2>
        </div>
        <div class="file-manager-popbox">
            <div class="file-manager-popbox-header">
                <h3>Upload File</h3>
                <button onclick="closeModal()">&times;</button>
            </div>
            <div class="progress">
                <div class="progressbar" style="width: 0%;">
                    <span class="tooltip"></span>
                </div>
            </div>
            <div class="file-manager-popbox-body">
                <br><br><br>
                <center>
                    <form id="upload_file" method="POST" enctype="multipart/form-data">
                        <input type="file" name="fl_upload" id="fl_upload" required/>
                        <button type="button" onclick="uploadFile()">Upload</button>
                    </form>
                    <br><br>
                    <p class="status"></p>
                    <p class="process"></p>
                </center>               
            </div>
        </div>
        <div class="file-manager-header-panel">
            <button>New File</button>
            <button>New Folder</button>
            <button onclick="openModal()">Upload File</button>
        </div>
        <div class="file-manager-body">
            <div class="left-panel">
            </div>
            <div class="right-panel">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Date</th>
                    </tr>
                    <?php
                        require 'DB.php';
                        $filesql = $con->query("SElECT * FROM files")->fetchAll();
                        foreach($filesql as $file){
                            echo "<tr class='file_list'>";
                            echo "<td>" . $file->name . "</td>";
                            echo "<td>" . $file->size . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($file->date)) . "</td>";
                            echo "</tr>";       
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>