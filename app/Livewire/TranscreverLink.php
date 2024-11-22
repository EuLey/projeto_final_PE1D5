<?php

namespace App\Livewire;

use App\Models\Transcription;
use App\Models\Video;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;
use YoutubeDl\Exception\YoutubeDlException;
use Illuminate\Support\Facades\Storage;

class TranscreverLink extends Component
{
    public $link;
    public $transcricao;

    public function render()
    {
        return view('livewire.transcrever-link');
    }

    public function transcreverLink()
    {
        if (!$this->link) {
            session()->flash('error', 'O link é obrigatório.');
            return;
        }

        try {
            // Caminho para salvar o arquivo na pasta public
            $outputDir = public_path('downloads');

            // Certifique-se de que o diretório existe
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            // Nome do arquivo final
            $uniqueName = 'audio_' . time() . '_' . uniqid();
            $outputFile = $outputDir . '/' . $uniqueName  . '.%(ext)s';

            // Caminho do yt-dlp
            $ytDlpPath = realpath(base_path('yt-dlp/yt-dlp.exe'));

            // Comando do yt-dlp
            $command = sprintf(
                '%s --extract-audio --output "%s" "%s"',
                $ytDlpPath,
                $outputFile,
                escapeshellarg($this->link)
            );

            // Executa o comando
            shell_exec($command);

            // Verifica se o arquivo foi baixado
            $downloadDir = glob($outputDir . '/*', GLOB_NOCHECK);
            foreach ($downloadDir as $file) {
                $basename = basename($file);
                if (Str::contains($basename, $uniqueName)) {
                    $downloadedFile = $file;
                }
            }

            if (empty($downloadedFile)) {
                $this->transcricao = 'Erro ao baixar o arquivo de áudio.';
                return;
            }

            // Pega o primeiro arquivo encontrado
            $audioPath = $downloadedFile;

            // Chave de API da OpenAI
            $apiKey = env('OPENAI_API_KEY');

            if (!$apiKey) {
                $this->transcricao = 'Chave de API não configurada.';
                return;
            }

            // Cliente HTTP para fazer a requisição
            $client = new Client();

            // Faz a requisição para a API do Whisper
            $response = $client->post('https://api.openai.com/v1/audio/transcriptions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ],
                'verify' => false,
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($audioPath, 'r'),
                        'filename' => basename($audioPath),
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
            } else {
                $this->transcricao = 'Erro ao transcrever o áudio.';
            }
            // Salva o vídeo no banco de dados
            $video = Video::create([
                'titulo' => basename($downloadedFile),
                'data_envio' => now(), // Melhor do que usar date()
                'id_usuario' => auth()->id(),
            ]);

            // Salva a transcrição no banco de dados
            Transcription::create([
                'texto' => $result['text'] ?? 'Transcrição não gerada.',
                'data_geracao' => now(),
                'id_video' => $video->id, // Usa o ID diretamente
            ]);
        } catch (\Exception $e) {
            $this->transcricao = 'Erro: ' . $e->getMessage();
        }
    }
}
