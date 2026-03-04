<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class ContentMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Sobre Nós',
                'slug' => 'sobre',
                'description' => 'A Mi Fire é uma das empresas que integram o Grupo Mat Incêndio, fornecendo soluções de combate a incêndio desde 1992.',
                'content' => '
<h2>MIFIRE, mais de 35 anos fornecendo soluções de combate a incêndio.</h2>
<p>A Mi Fire é uma das empresas que integram o Grupo Mat Incêndio, composto também pela Mi Fire Engenharia e pela Mi Fire Serviços.</p>
<p>A empresa iniciou suas atividades no Brasil em 1992, sob a denominação Mat-Incêndio, fabricando extintores de incêndio e, posteriormente, projetando e executando Sistemas de Combate a Incêndio.</p>
<p>Sua trajetória de mais de três décadas consolidou uma tradição de excelência como fornecedora nesses segmentos. Os projetos e equipamentos da Mi Fire estão presentes em diversos países e em inúmeras obras de grande relevância no Brasil.</p>
<p>A missão da empresa é oferecer soluções que atendam plenamente às necessidades de seus clientes, contribuindo para o sucesso de seus negócios. Para isso, conta com uma equipe de profissionais altamente qualificados, em constante busca por melhorias e aprimoramento de seus produtos, garantindo soluções técnicas e comerciais de elevado padrão.</p>
<p>Com sede no Rio de Janeiro, a Mi Fire atua no desenvolvimento de projetos, fornecimento e montagem de Sistemas de Detecção e Combate a Incêndio, atendendo os setores Offshore (Plataformas), Onshore (Refinarias e Petroquímicas), Naval (Petroleiros, PSV’s, etc.) e Industrial.</p>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Dry-Flo®',
                'slug' => 'diluvioseco',
                'description' => 'A tecnologia Dry-Flo®.',
                'content' => '
<h2>Dry-Flo®</h2>
<p>Entre em contato para saber mais sobre o sistema de Dilúvio Seco da MiFire.</p>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Notifier',
                'slug' => 'notifier',
                'description' => 'Soluções em Detecção e Alarme de Incêndio da Notifier',
                'content' => '
<h2>Painéis de Detecção e Alarme de Incêndio NOTIFIER</h2>
<p>Comercialização, instalação, startup e manutenção de todas as linhas de produtos NOTIFIER, incluindo a Série INSPIRE N16e e Série ONYX®.</p>
<h3>Dispositivos de Campo</h3>
<ul>
    <li>Detectores e Bases</li>
    <li>Acionadores Manuais (Endereçáveis e Convencionais)</li>
    <li>Módulos de Interface (Controle, Monitores, Combate, Isoladores)</li>
    <li>Sinalizadores Sonoros, Visuais e Audiovisuais</li>
    <li>Fontes Auxiliares e Comunicação de Rede</li>
</ul>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Extintores',
                'slug' => 'extintores',
                'description' => 'Extintores de Incêndio de alta performance.',
                'content' => '
<h2>Extintores</h2>
<p>Os extintores da linha de CO2 (alta pressão) são produzidos dentro dos mais rígidos padrões de qualidade. Nossa moderna unidade fabril em São Paulo, dotada de maquinário com tecnologia de ponta, garante a segurança e eficiência de nossos produtos. São mais de 27 anos de experiência e tradição.</p>
<h3>Portáteis</h3>
<p>Modelos de 4kg e outras capacidades.</p>
<h3>Sobre Rodas</h3>
<p>Modelos de CO2 de 10kg, 25kg e 50kg.</p>
<h3>Válvulas e Componentes</h3>
<p>Válvulas M30 e CO2 Alta Pressão. Suportes Universais.</p>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Sistemas de Combate',
                'slug' => 'sistemas',
                'description' => 'Diferentes sistemas fixos de combate a incêndio oferecidos pela MiFire.',
                'content' => '
<h2>Sistemas de Combate a Incêndio</h2>
<ul>
    <li><strong>Sistema Fixo de CO2</strong></li>
    <li><strong>Sistema Fixo de Água</strong></li>
    <li><strong>Sistema Fixo de Espuma</strong></li>
    <li><strong>Sistema Fixo de Agente Limpo (Novec e FM-200)</strong></li>
</ul>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Sistema Fixo de Agente Limpo',
                'slug' => 'sistema-fixo-de-agente-limpo',
                'description' => 'Soluções avançadas como NOVEC 1230 e FM-200.',
                'content' => '
<h2>NOVEC 1230</h2>
<p>O Novec 1230 é a próxima geração em substituição ao halon, projetado para minimizar as preocupações com a segurança humana, desempenho e meio ambiente. Diferentemente dos HFCs da primeira geração, o fluido Novec 1230 tem as características-chave de um agente sustentável:</p>
<ul>
    <li>Potencial zero de agressão à camada de ozônio;</li>
    <li>Tempo de vida na atmosfera de apenas 5 dias;</li>
    <li>Potencial de aquecimento global igual a 1;</li>
    <li>Grande margem de segurança para áreas ocupadas;</li>
    <li>Não danifica os equipamentos protegidos.</li>
</ul>
<h3>Estação de Recarga</h3>
<p>Nossa unidade em São Paulo está equipada com uma estação de recarga/manutenção de cilindros, com certificação UL.</p>
<h2>FM-200</h2>
<p>O FM-200 é o Heptafluoropropano, excelente agente de substituição limpa para Halon 1301.</p>
                ',
                'is_active' => true,
                'show_in_menu' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
