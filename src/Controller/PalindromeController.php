<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class PalindromeController extends AbstractController
{

    #[Route('/palindrome', name: 'app_palindrome')]
    public function index(): Response
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $text = $_POST["text"];
            $words = explode(",", $text);
            // Palindromları bul
            $palindromes = array_filter($words, function ($word) {
                return strtolower(preg_replace("/[^A-Za-z0-9]/", "", $word)) == strrev(strtolower(preg_replace("/[^A-Za-z0-9]/", "", $word)));
            });

            // Yazdırılmış palindromları takip et
             $printed_palindromes = [];

// JSON dosyasının yolu
            $json_dosya_yolu = dirname(__FILE__) . '/../../text.json';
// JSON dosyasını kontrol et ve verileri oku
            if (file_exists($json_dosya_yolu)) {
                try {
                    $json_veri = file_get_contents($json_dosya_yolu);
                    $data = json_decode($json_veri);
                    // JSON verilerini kullanabilirsiniz
                    //echo json_encode($data);
                } catch (JsonException $e) {
                    //echo "JSON dosyası geçerli bir JSON formatına sahip değil.";
                }
            } else {
                echo "JSON dosyası bulunamadı.";
            }



            // Palindromları yazdır
            foreach ($palindromes as $palindrome) {
                $cleaned_palindromes = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $palindrome));
                if (strlen($cleaned_palindromes) > 2 && !in_array(strtolower($cleaned_palindromes), $printed_palindromes)) {
                    if ($cleaned_palindromes === strrev($cleaned_palindromes)) {
                        //echo "<div>".$palindrome."</div>" . "<br>";
                        //echo $palindrome . "<br>";
                    }
                    $printed_palindromes[] = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '' , $cleaned_palindromes));
                }
            }
        }
        $iterator = new \ArrayIterator($data);
        $toplamKarakterSayisi = 0;
        while ($iterator -> valid()){
            $kelime = $iterator-> current();
            $toplamKarakterSayisi += strlen($kelime);
            $iterator->next();
        }
        //echo "Toplam karakter sayısı: $toplamKarakterSayisi";
        return $this->render('palindrome/index.html.twig',[
            'palindrome' => @$printed_palindromes,
            'error' => 'Girdiğiniz metin içinde palindrom kelime bulunamadı.',
            'words' => @$words,
            'data' => @$data,
            'len' => @$toplamKarakterSayisi
        ]);
    }
}
