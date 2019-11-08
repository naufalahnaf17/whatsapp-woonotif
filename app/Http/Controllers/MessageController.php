<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MessageController extends Controller
{
    // Awal Function Index
    public function index()
    {
      return view('message');
    }
    // Akhir Function Index

    // Awal Function Send
    public function send(Request $request)
    {
      // Inisialisasi Client Guzzle
      $client = new Client();

      // Make Raw Content In Body With Guzzle
      $token = '15a5475dddf14b76254be32384b350ed2c416554ca8eb67c';
      $array = [
        'phone_no' => $request->input('no'),
        'key' => $token,
        'message' => $request->input('pesan')
      ];

      // Menghubungkan Raw Content Dengan Api Woonotif
      try {

        $response = $client->request('POST', 'http://send.woonotif.com/api/send_message', [
            'body' => json_encode($array),
            'headers' => [
                'Content-Type'     => 'application/json',
            ]
        ]);

      } catch (ClientException  $e) {
        return response('Terjadi Kesalahan');
      }

      if ($response->getStatusCode() == 200) {
        $response_data = $response->getBody()->getContents();
        $detail = json_decode($response_data,true);
        return redirect('/');
      }else {
        return response('Terjadi Kesalahan');
      }


    }
    // Akhir Function Send

}
