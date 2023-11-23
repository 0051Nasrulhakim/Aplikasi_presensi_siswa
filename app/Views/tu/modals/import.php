<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url()?>/export/import_siswa" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <!-- file excell -->
                <div class="mb-3">
                    <label for="file" class="form-label">Import File Daftar Siswa</label>
                    <!-- <input class="form-control" type="file" name="file" id="file"> -->
                    <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" /></p>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </form>
  </div>
</div>