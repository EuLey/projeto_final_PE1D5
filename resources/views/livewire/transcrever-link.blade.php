<div class="row justify-content-center" >
    <div class="col-6">
        <div class="card card-danger" style="border-radius: 15px 15px 15px 15px">
            <div class="card-header d-flex align-items-center justify-content-center" style="border-radius: 15px 15px 0 0">
                <h3 class="card-title text-center">TRANSCRIÇÃO DE VÍDEO DO YOUTUBE</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form wire:submit="transcreverLink">
                <div class="card-body">
                    <div class="form-group">
                        <label for="link">URL do Vídeo:</label>
                        <input type="text" class="form-control" id="link" placeholder="Email" wire:model="link">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-center" style="border-radius: 0 0 15px 15px">
                    <button type="submit" class="btn btn-danger">Transcrever</button>
                </div>
            </form>
        </div>
        <div class="card card-danger" style="border-radius: 15px 15px 15px 15px">
            <div class="card-header d-flex align-items-center justify-content-center" style="border-radius: 15px 15px 0 0">
                <h3 class="card-title text-center">TRANSCRIÇÃO DO ÁUDIO</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="border p-2 rounded">{{ $transcricao ?: 'Selecione um áudio para transcrever...' }}</div>
            </div>
        </div>
    </div>
</div>
