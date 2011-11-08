Apresentação
============
Este webservise visa a centralização de mecanismos de frete utilizados pelos
projetos da F1 Soluções.


Funcionamento
=============
Uma loja fará uma requisição por POST para o webservice com os tipos de frete ao
quais esta desejar saber os valores e prazos, para isto serão necessárias as 
seguintes informações:

cep_origem     -> 8 dígitos
cep_destino    -> 8 dígitos
correios_login -> 
correios_senha ->
jadlog_login   ->
jadlog_senha   ->
cnpj -> 
valor_produtos -> em centavos sem casa decimais ex.: 1020 para R$10,20

produtos
	0
		altura      -> em cm sem casas decimais.
		largura     -> em cm sem casas decimais.
		comprimetno -> em cm sem casas decimais.
		diametro    -> em cm sem casas decimais.
		peso        -> em gramas(g) sem casas decimais.
		quantidade  -> número de ítens

opcoes
	0
		codigo -> 1 ou 2 dígitos
		*vide valores específicos para cada modalidade de frete
	

Como resposta a loja requisitante terá um XML no seguinte formato:
<fretes>
	<pac>
		<erro>0</erro>
		<nome>Pac</nome>
		<codigo>1</codigo>
		<valor>1000</valor>
		<prazo>10</prazo>
	</pac>
	<expresso>
		<erro>0</erro>
		<nome>Sedex</nome>
		<codigo>2</codigo>
		<valor>1500</valor>
		<prazo>5</prazo>
	</expresso>
	<sedex>
		<erro>101</erro>
		<nome>Sedex</nome>
	</sedex>
</fretes>

Onde:
erro   = Se igual à  0, indica que não houveram erros na transação
tipo_n = serão apresentados tantos tipos quantos forem requisitados
nome   = nome do tipo de frete em questão
codigo = Código que representa o tipo de frete no webservice
valor  = Preço em centavos sem virgulas do frete
prazo  = Tempo em dias que após a emissão será levado para entrega

Obs.: Para verificar os erros possí­veis vide o arquivo tabela_erros.xls


Valores para consulta JadLog
============================

modalidade    -> Modalidade do frete. Deve conter apenas números
seguro        -> Tipo do Seguro 'N' normal 'A' apólice própria
valor_coleta  -> Valor da coleta negociado com a unidade JADLOG. em centavos sem
                 casas decimais
pagar_destino -> Frete a pagar no destino, 'S' = sim 'N' = não.
tipo_entrega  -> Tipo de entrega 'R' retira unidade JADLOG, 'D' domicilio.


Valores para consulta Correios
==============================

formato                 -> (1 ou 2) 1 - caixa | 2 - prisma
servico_adicional       -> S ou N
valor_servico_adicional -> se servico_adicional = 'S' então deve ser declarado 
                           valor do serviço em centavos sem casas decimais
aviso_recebimetno       -> S ou N

