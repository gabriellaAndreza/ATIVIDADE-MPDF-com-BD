<?php
require 'vendor/autolad.php'; 
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

$query = "SELECT titulo, autor, ano_publicado, resumo FROM livros";
$stmt = $pdo->prepare(query: $query);
$stmt->execute();

$livros = $stmt-> fetchALL(PDO:: FETCH_ASSOC);

$mpdf = new \Mpdf\Mpdf();
 
$html = '<h1>Biblioteca - Lista de livros<h1>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" width="100%">';
$html .= '<tr>
                <th>título</th>
                <th>autor</th>
                <th>ano de publicação</th>
                <th>resumo</th>
            </tr>';

foreach ($livros as $livro) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars(string: $livro['titulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['autor']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['ano_publicacao']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['resumo']) . '</td>';
    $html .= '</tr>';
}
 
$mpdf->writeHTML(html: $html);
 
$mpdf->Output(name: 'lista_de_livros.pdf', dest: \Mpdf\Output\Destination::DOWLOAD);
 
{
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}catch (\Mpdf\MpdfExcepition $e) {
    echo "Erro ao gerar o PDF: " . $e-> gerMessage();
}
