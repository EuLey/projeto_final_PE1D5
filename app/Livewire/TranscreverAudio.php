<?php

namespace App\Livewire;

use App\Models\Transcription;
use App\Models\Video;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class TranscreverAudio extends Component
{
    use WithFileUploads;

    public $audio;
    public $transcricao;

    public function render()
    {
        return view('livewire.transcrever-audio');
    }

    public function transcreverAudio()
    {
        $this->validate([
            'audio' => 'required|file|mimes:mp3,wav,mp4',
        ]);

        // Caminho completo para salvar na pasta public/downloads
        $destinationPath = public_path('downloads');

        // Certifique-se de que o diretório existe
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        // Gera um nome único para o arquivo
        $uniqueName = 'audio_' . time() . '_' . uniqid() . '.' . $this->audio->getClientOriginalExtension();
        // Salva o arquivo em public/downloads
        $path = $this->audio->storeAs('downloads', $uniqueName, ['disk' => 'public_uploads']);
        $fullAudioPath = $destinationPath . '/' . $uniqueName;
        Log::info('Caminho do áudio armazenado: ' . $fullAudioPath);

        // Chave de API da OpenAI
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            $this->transcricao = 'Chave de API não configurada.';
            return;
        }

        // Cliente HTTP para fazer a requisição
        $client = new Client();

        try {
            // Faz a requisição para a API do Whisper
            $response = $client->post('https://api.openai.com/v1/audio/transcriptions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ],
                'verify' => false,
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($fullAudioPath, 'r'),
                        'filename' => basename($fullAudioPath),
                    ],
                    [
                        'name' => 'model',
                        'contents' => 'whisper-1',
                    ],
                ],
            ]);

            // Decodifica a resposta
            $result = json_decode($response->getBody(), true);

            if (isset($result['text'])) {
                $this->transcricao = $result['text'];

                // Salva no banco de dados
                $video = Video::create([
                    'titulo' => basename($uniqueName), // Nome do arquivo sem o caminho completo
                    'data_envio' => now(),
                    'id_usuario' => auth()->id(),
                ]);

                Transcription::create([
                    'texto' => $result['text'],
                    'data_geracao' => now(),
                    'id_video' => $video->id,
                ]);
            } else {
                $this->transcricao = 'Erro ao transcrever o áudio.';
            }
        } catch (\Exception $e) {
            $this->transcricao = 'Erro ao processar: ' . $e->getMessage();
            Log::error($e->getMessage());
        }
    }
}
