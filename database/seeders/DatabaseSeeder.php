<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BusinessInfo;
use App\Models\Contact;
use App\Models\EstimatorDevice;
use App\Models\EstimatorIssue;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Administrador',
                'username' => 'admin',
                'email' => 'geral@gtatech.ao',
                'password' => Hash::make('gta2026'),
                'role' => 'admin',
                'display_name' => 'Administrador',
                'active' => true,
            ]);
            $this->command->info('Admin user created: admin / gta2026');
        }

        if (BusinessInfo::count() === 0) {
            BusinessInfo::create([
                'id' => 'main',
                'company_name' => 'GTA-Tech',
                'address' => 'Rua do Comércio, Edifício Mandarim, R/C - Cabinda, Angola',
                'phone' => '+244 923 125 487',
                'email' => 'geral@gtatech.ao',
                'working_hours' => 'Segunda a Sábado: 08:00 - 18:00',
                'about' => 'Assistência Técnica de Smartphones & Computadores. Somos especialistas na reparação premium de dispositivos móveis e computadores em Cabinda. Garantimos reparos rápidos com peças originais e garantia certificada.',
                'facebook' => '',
                'instagram' => '',
                'whatsapp' => '244923125487',
                'logo' => '',
            ]);
            $this->command->info('Default business info created');
        }

        if (Service::count() === 0) {
            $services = [
                ['title' => 'Reparação de Ecrãs', 'description' => 'Substituição de ecrãs partidos, falhas no touch screen ou manchas no display com calibração integral de cores.', 'icon' => 'Smartphone', 'features' => ['Peças originais ou alta gama equiparável', 'Calibração de brilho e TrueTone original', 'Garantia de 90 dias contra defeito de fabrico'], 'price_range' => 'A partir de 18.000 Kz', 'avg_time' => '45 minutos'],
                ['title' => 'Substituição de Baterias', 'description' => 'Bateria descarrega rápido ou telemóvel desliga sozinho? Trocamos por baterias com ciclos zerados e chip de segurança.', 'icon' => 'BatteryCharging', 'features' => ['Baterias com homologação CE e alta densidade', 'Exibição da saúde de bateria no sistema', 'Elimina aquecimentos indesejados'], 'price_range' => 'A partir de 12.000 Kz', 'avg_time' => '30 minutos'],
                ['title' => 'Reparação de Placa Mãe', 'description' => 'Microsoldadura avançada, diagnóstico de curto-circuito, recuperação de danos por água e reparos integrados.', 'icon' => 'Cpu', 'features' => ['Especialistas certificados em microeletrónica', 'Equipamento de laboratório de alta precisão', 'Recuperação de dados críticos inclusa'], 'price_range' => 'Sob orçamento', 'avg_time' => '24 - 48 horas'],
                ['title' => 'Manutenção de Conetores & Portas', 'description' => 'Substituição de portas de carregamento USB-C, Lightning, tomadas de auscultadores e grelhas de áudio.', 'icon' => 'Plug', 'features' => ['Substituição do flex de carga completo', 'Limpeza interna de poeiras grátis', 'Testes de corrente elétrica e voltagem'], 'price_range' => 'A partir de 8.000 Kz', 'avg_time' => '40 minutos'],
                ['title' => 'Assistência de Computadores & Mac', 'description' => 'Formatação, substituição de teclado, reparos na carcaça e dobradiças, re-aplicação de massa térmica e upgrades.', 'icon' => 'Laptop', 'features' => ['Troca de disco HDD para SSD Ultra Rápido', 'Limpeza física profunda e substituição de ventoinhas', 'Otimização de sistema Windows / macOS'], 'price_range' => 'A partir de 15.000 Kz', 'avg_time' => '1 - 3 horas'],
                ['title' => 'Recuperação & Backup de Dados', 'description' => 'Dispositivo bloqueado no loop do logótipo? Recuperamos os seus dados, fazemos backups e reinstalações completas.', 'icon' => 'CloudLightning', 'features' => ['Recuperação segura sem perda de fotos', 'Resolução de erros de boot e atualizações mal-sucedidas', 'Aconselhamento sobre backups automáticos'], 'price_range' => 'A partir de 10.000 Kz', 'avg_time' => '1 a 2 horas'],
            ];

            foreach ($services as $data) {
                Service::create($data);
            }
            $this->command->info('Services seeded: '.count($services));
        }

        if (Brand::count() === 0) {
            $brands = [
                ['name' => 'Apple', 'logo' => 'apple'],
                ['name' => 'Samsung', 'logo' => 'samsung'],
                ['name' => 'Xiaomi', 'logo' => 'xiaomi'],
                ['name' => 'Huawei', 'logo' => 'huawei'],
                ['name' => 'Infinix', 'logo' => 'infinix'],
                ['name' => 'HP', 'logo' => 'hp'],
                ['name' => 'Dell', 'logo' => 'dell'],
                ['name' => 'Lenovo', 'logo' => 'lenovo'],
                ['name' => 'Asus', 'logo' => 'asus'],
            ];

            foreach ($brands as $data) {
                Brand::create($data);
            }
            $this->command->info('Brands seeded: '.count($brands));
        }

        if (ProcessStep::count() === 0) {
            $steps = [
                ['step' => 1, 'title' => 'Entrada & Diagnóstico', 'description' => 'Análise minuciosa gratuita do seu dispositivo em laboratório para detetar a origem exata do problema.', 'icon' => ''],
                ['step' => 2, 'title' => 'Orçamento Transparente', 'description' => 'Apresentamos-lhe o custo final e os prazos antes de avançarmos. Só reparamos com a sua aprovação total.', 'icon' => ''],
                ['step' => 3, 'title' => 'Reparação Especializada', 'description' => 'Técnicos certificados operam o seu dispositivo em bancadas ESD e substituem peças com ferramentas calibradas.', 'icon' => ''],
                ['step' => 4, 'title' => 'Garantia & Entrega', 'description' => 'Efetuamos mais de 15 testes de qualidade pós-reparo e entregamos o equipamento com garantia escrita de 90 dias.', 'icon' => ''],
            ];

            foreach ($steps as $data) {
                ProcessStep::create($data);
            }
            $this->command->info('Process steps seeded: '.count($steps));
        }

        if (Testimonial::count() === 0) {
            $testimonials = [
                ['name' => 'Abraão Kiala', 'role' => 'iPhone 13 Pro Max (Substituição de Vidro e Bateria)', 'avatar' => '', 'rating' => 5, 'text' => 'Serviço cinco estrelas! O meu iPhone ficou como novo em menos de uma hora. Atendimento super cordial e o diagnóstico foi feito à minha frente. Recomendo imenso a GTA-Tech em Cabinda.'],
                ['name' => 'Elizabete Neves', 'role' => 'HP Pavilion 15 (Upgrade SSD e Limpeza de Cooler)', 'avatar' => '', 'rating' => 5, 'text' => 'O meu computador estava lentíssimo e a aquecer muito. Depois de irem à GTA-Tech, agora inicia em 5 segundos e está super silencioso. Preço excelente e técnicos muito transparentes.'],
                ['name' => 'Domingos Chimpene', 'role' => 'Samsung Galaxy S22 Ultra (Reparação de Placa / Conetor)', 'avatar' => '', 'rating' => 5, 'text' => 'Eles resolveram uma falha na placa principal que em outras casas disseram que não tinha reparo. O processo de estimativa de preço foi super exato e cumpriram o prazo à risca.'],
            ];

            foreach ($testimonials as $data) {
                Testimonial::create($data);
            }
            $this->command->info('Testimonials seeded: '.count($testimonials));
        }

        if (Faq::count() === 0) {
            $faqs = [
                ['question' => 'Quanto tempo demora em média uma reparação?', 'answer' => 'Reparos comuns como ecrãs e baterias levam de 30 a 60 minutos. Já as intervenções mais complexas na placa ou reparação de portáteis levam entre 2 e 24 horas, consoante o trabalho.', 'sort_order' => 0],
                ['question' => 'Vocês dão garantia dos serviços efetuados?', 'answer' => 'Sim, absolutamente! Todas as nossas reparações têm uma garantia certificada de 90 dias (3 meses), cobrindo qualquer defeito de fabrico das peças substituídas.', 'sort_order' => 1],
                ['question' => 'O diagnóstico do meu dispositivo tem algum custo?', 'answer' => 'Na GTA-Tech o diagnóstico é totalmente gratuito. Abrimos e diagnosticamos o telemóvel ou computador gratuitamente e só paga se der autorização para avançar com a reparação.', 'sort_order' => 2],
                ['question' => 'As peças utilizadas são originais?', 'answer' => 'Utilizamos peças originais para a maioria das marcas. Nos casos em que o fabricante não fornece peças diretamente, recorremos a fornecedores com certificação de Alta Gama (Grade A+), garantindo o mesmo brilho, cores e longevidade.', 'sort_order' => 3],
            ];

            foreach ($faqs as $data) {
                Faq::create($data);
            }
            $this->command->info('FAQs seeded: '.count($faqs));
        }

        if (Feature::count() === 0) {
            $features = [
                ['title' => 'Reparações Expresso', 'description' => 'Mais de 85% das reparações de ecrã ou substituições de baterias são efetuadas e concluídas em menos de 1 hora.', 'badge' => 'Velocidade Máxima', 'icon' => 'Timer', 'sort_order' => 0],
                ['title' => 'Diagnóstico 100% Gratuito', 'description' => 'Na GTA-Tech avaliamos o seu telemóvel ou computador fisicamente sem cobrar nada. Só avança se aprovar o orçamento.', 'badge' => 'Sem Compromisso', 'icon' => 'HeartHandshake', 'sort_order' => 1],
                ['title' => 'Garantia de 90 Dias', 'description' => 'Todas as nossas intervenções e substituições de componentes vêm com uma garantia de 3 meses registada por escrito.', 'badge' => 'Tranquilidade Total', 'icon' => 'ShieldCheck', 'sort_order' => 2],
                ['title' => 'Peças de Alta Gama', 'description' => 'Damos primazia a componentes de teor original com calibração de TrueTone e taxas de refresco idênticas de fábrica.', 'badge' => 'Qualidade Premium', 'icon' => 'Award', 'sort_order' => 3],
                ['title' => 'Laboratório Antiestático', 'description' => 'Dispomos de equipamentos profissionais calibrados contra descargas eletrostáticas, garantindo integridade total da placa.', 'badge' => 'Segurança Total', 'icon' => 'CheckCircle', 'sort_order' => 4],
                ['title' => 'Centralizados em Cabinda', 'description' => 'Estamos localizados numa área nobre com segurança e fácil estacionamento para sua total comodidade.', 'badge' => 'Estacionamento Fácil', 'icon' => 'MapPin', 'sort_order' => 5],
            ];

            foreach ($features as $data) {
                Feature::create($data);
            }
            $this->command->info('Features seeded: '.count($features));
        }

        if (Product::count() === 0) {
            $products = [
                ['name' => 'iPhone 12 Pro Max 256GB', 'category' => 'smartphones', 'price' => 320000, 'original_price' => 350000, 'image' => '', 'description' => 'Bateria a 100%, sem marcas de uso. Inclui todos os acessórios de carga rápida e garantia de 90 dias.', 'specs' => ['Super Retina XDR de 6.7"', 'Processador A14 Bionic', 'Tripla Câmara Pro 12MP', 'Face ID & Proteção IP68']],
                ['name' => 'Samsung Galaxy S22 Ultra 5G', 'category' => 'smartphones', 'price' => 380000, 'original_price' => 410000, 'image' => '', 'description' => 'Ecrã 120Hz dinâmico, excelente vida útil da bateria de alto rendimento. Inclui S-Pen original integrada.', 'specs' => ['Ecrã Dynamic AMOLED 2X', 'Processador Exynos 2200', 'Super Câmara Zoom 108MP', 'Carregamento Ultra Rápido']],
                ['name' => 'HP EliteBook 840 G6 Slim i5', 'category' => 'laptops', 'price' => 295000, 'original_price' => 330000, 'image' => '', 'description' => 'Ideal para escritório, negócios e universidade. Corpo de alumínio, extremamente veloz.', 'specs' => ['Core i5 de 8ª Geração', '16GB RAM Integrada', '512GB NVMe SSD Ultra Rápido', 'Ecrã 14" Full HD Antirreflexo']],
                ['name' => 'Carregador Ultra Rápido 20W USB-C', 'category' => 'accessories', 'price' => 8500, 'original_price' => null, 'image' => '', 'description' => 'Carregador de parede certificado Power Delivery 20W. Carregamento ultra seguro e inteligente.', 'specs' => ['Certificado Power Delivery 3.0', 'Tensão Inteligente Auto-ajustável', 'Alta Proteção Contra Picos']],
                ['name' => 'Power Bank Premium 15000mAh PD', 'category' => 'accessories', 'price' => 18000, 'original_price' => 22000, 'image' => '', 'description' => 'Altamente portátil. Carrega até dois telemóveis em simultâneo com estabilização de voltagem automática.', 'specs' => ['Capacidade Real 15.000mAh', 'Indicador LED de Percentual', 'Duplo Slot USB & USB-C']],
                ['name' => 'Auscultadores Bluetooth TWS Premium', 'category' => 'accessories', 'price' => 14500, 'original_price' => null, 'image' => '', 'description' => 'Som estéreo acústico excelente, com isolamento passivo profundo e microfone HD.', 'specs' => ['Conectividade Bluetooth 5.3', 'Autonomia de Bateria até 24h', 'Controlo por Toques Inteligente']],
                ['name' => 'iPad 9ª Geração 64GB Wi-Fi', 'category' => 'tablets', 'price' => 210000, 'original_price' => 240000, 'image' => '', 'description' => 'Tablet versátil para estudo e trabalho. Ecrã Retina 10.2" com True Tone, processador A13 Bionic.', 'specs' => ['Ecrã Retina 10.2" com True Tone', 'Processador A13 Bionic', '64GB de Armazenamento', 'Touch ID & Câmara 8MP']],
                ['name' => 'Samsung Galaxy Tab A8 64GB', 'category' => 'tablets', 'price' => 135000, 'original_price' => null, 'image' => '', 'description' => 'Tablet ideal para entretenimento e produtividade. Ecrã imersivo de 10.5" com altifalantes quadruplos AKG.', 'specs' => ['Ecrã TFT 10.5"', 'Processador Unisoc T618', '64GB Expansível até 1TB', 'Altifalantes AKG com Dolby Atmos']],
                ['name' => 'Apple Watch SE 2ª Geração 40mm', 'category' => 'wearables', 'price' => 135000, 'original_price' => 155000, 'image' => '', 'description' => 'Smartwatch completo com monitorização de saúde avançada, GPS integrado e notificações inteligentes.', 'specs' => ['Monitorização de Sono e Oxímetro', 'GPS + GLONASS Integrado', 'Resistente à Água 50m', 'Sistema watchOS 10']],
                ['name' => 'Cabo USB-C para Lightning 1m Original', 'category' => 'accessories', 'price' => 5500, 'original_price' => null, 'image' => '', 'description' => 'Cabo de carregamento e sincronização certificado MFi. Trançado em nylon para maior durabilidade.', 'specs' => ['Certificação Apple MFi', 'Trançado em Nylon Reforçado', 'Comprimento de 1 Metro', 'Carregamento Rápido 20W']],
                ['name' => 'MacBook Air M1 2020 8GB/256GB', 'category' => 'laptops', 'price' => 375000, 'original_price' => 420000, 'image' => '', 'description' => 'Portátil silencioso e extremamente rápido. Bateria com duração até 18 horas, ecrã Retina 13.3" e chip M1.', 'specs' => ['Apple M1 Chip 8-Core', '8GB RAM Unificada', '256GB SSD', 'Ecrã Retina 13.3"', 'Touch ID', 'Até 18h de Bateria']],
            ];

            foreach ($products as $data) {
                Product::create($data);
            }
            $this->command->info('Products seeded: '.count($products));
        }

        if (EstimatorDevice::count() === 0) {
            $smartphone = EstimatorDevice::create(['name' => 'Smartphones / Telemóveis', 'icon' => '', 'base_price' => 0]);
            $laptop = EstimatorDevice::create(['name' => 'Computadores Portáteis', 'icon' => '', 'base_price' => 0]);
            $tablet = EstimatorDevice::create(['name' => 'Tablets / iPads', 'icon' => '', 'base_price' => 0]);

            $avgPrices = [
                $smartphone->id => [22000, 12500, 8500, 19000, 32000, 15000],
                $laptop->id => [15000, 28000, 48000, 18500, 12000],
                $tablet->id => [26000, 16000, 9000],
            ];

            $issues = [
                $smartphone->id => [
                    ['name' => 'Ecrã Partida / Sem Imagem', 'price_multiplier' => 22000],
                    ['name' => 'Bateria Viciada / Descarrega Rápido', 'price_multiplier' => 12500],
                    ['name' => 'Não Carrega / Porta Solta', 'price_multiplier' => 8500],
                    ['name' => 'Molhado / Danos por Líquidos', 'price_multiplier' => 19000],
                    ['name' => 'Não Liga / Curto-circuito na Placa', 'price_multiplier' => 32000],
                    ['name' => 'Câmara Traz / Frente sem Foco', 'price_multiplier' => 15000],
                ],
                $laptop->id => [
                    ['name' => 'Limpeza, Formatação e Instalação de OS', 'price_multiplier' => 15000],
                    ['name' => 'Instaurar SSD Rápido de 256GB/512GB', 'price_multiplier' => 28000],
                    ['name' => 'Ecrã do Portátil Partida / Listas', 'price_multiplier' => 48000],
                    ['name' => 'Teclado Não Escreve ou Letras Soltas', 'price_multiplier' => 18500],
                    ['name' => 'Acolhimento de Ventoinha / Pasta Térmica Nova', 'price_multiplier' => 12000],
                ],
                $tablet->id => [
                    ['name' => 'Ecrã de Vidro Partida / Display', 'price_multiplier' => 26000],
                    ['name' => 'Bateria Inchada / Pouco Tempo Carga', 'price_multiplier' => 16000],
                    ['name' => 'Porta USB / Conector Carga', 'price_multiplier' => 9000],
                ],
            ];

            foreach ($issues as $deviceId => $deviceIssues) {
                $prices = $avgPrices[$deviceId];
                $avg = count($prices) > 0 ? array_sum($prices) / count($prices) : 1;

                foreach ($deviceIssues as $i => $issue) {
                    $price = $prices[$i] ?? 1;
                    EstimatorIssue::create([
                        'device_id' => $deviceId,
                        'name' => $issue['name'],
                        'price_multiplier' => $avg > 0 ? round($price / $avg, 2) : 1,
                    ]);
                }
            }

            $this->command->info('Estimator devices and issues seeded');
        }

        if (Gallery::count() === 0) {
            $galleries = [
                ['image' => '', 'title' => 'Laboratório de Microsoldadura', 'category' => 'laboratorio', 'description' => 'Bancada equipada com microscópio binocular e estação de solda de precisão.', 'sort_order' => 0],
                ['image' => '', 'title' => 'Bancada de Diagnóstico Avançado', 'category' => 'oficina', 'description' => 'Sistema de diagnóstico por software para placas lógicas de smartphones.', 'sort_order' => 1],
                ['image' => '', 'title' => 'Reparação de Ecrãs OLED', 'category' => 'antes-depois', 'description' => 'Substituição de ecrã partido com calibração TrueTone.', 'sort_order' => 2],
                ['image' => '', 'title' => 'Reballing de Processadores BGA', 'category' => 'laboratorio', 'description' => 'Microsoldadura de alto nível com estação de infravermelhos.', 'sort_order' => 3],
            ];
            foreach ($galleries as $data) {
                Gallery::create($data);
            }
            $this->command->info('Galleries seeded: '.count($galleries));
        }

        if (Team::count() === 0) {
            $team = [
                ['name' => 'João Silva', 'role' => 'Técnico Sénior', 'photo' => '', 'bio' => 'Mais de 10 anos de experiência em reparação de dispositivos móveis e microsoldadura.', 'social_links' => ['facebook' => '', 'instagram' => '', 'linkedin' => '', 'whatsapp' => ''], 'sort_order' => 0],
                ['name' => 'Maria Santos', 'role' => 'Atendimento ao Cliente', 'photo' => '', 'bio' => 'Especialista em diagnóstico e aconselhamento personalizado para cada cliente.', 'social_links' => ['facebook' => '', 'instagram' => '', 'linkedin' => '', 'whatsapp' => ''], 'sort_order' => 1],
                ['name' => 'Pedro Costa', 'role' => 'Técnico de Reparação', 'photo' => '', 'bio' => 'Certificado em reparação de smartphones e tablets das principais marcas.', 'social_links' => ['facebook' => '', 'instagram' => '', 'linkedin' => '', 'whatsapp' => ''], 'sort_order' => 2],
            ];
            foreach ($team as $data) {
                Team::create($data);
            }
            $this->command->info('Team seeded: '.count($team));
        }

        Contact::factory()->count(5)->create();
        $this->command->info('Sample contacts created');

        if (Setting::count() === 0) {
            Setting::create(['key' => 'instagram_url', 'value' => '']);
            Setting::create(['key' => 'facebook_url', 'value' => '']);
            Setting::create(['key' => 'tiktok_url', 'value' => '']);
            $this->command->info('Settings seeded');
        }
    }
}
