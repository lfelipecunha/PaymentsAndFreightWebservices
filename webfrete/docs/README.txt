Apresenta��o
============
Este webservise visa a centraliza��o de mecanismos de frete utilizados pelos
projetos da F1 Solu��es.


Funcionamento
=============
Uma loja far� uma requisi��o por POST para o webservice com os tipos de frete ao
quais esta desejar saber os valores e prazos, para isto ser�o necess�rias as 
seguintes informa��es:

cep_origem     -> 8 d�gitos
cep_destino    -> 8 d�gitos
jadlog_login   ->
jadlog_senha   ->
correios_login -> 
correios_senha ->
valor_produtos -> em centavos sem casa decimais ex.: 1020 para R$10,20

produtos
	0
		altura      -> em cm sem casas decimais.
		largura     -> em cm sem casas decimais.
		comprimetno -> em cm sem casas decimais.
		peso        -> em gramas(g) sem casas decimais.
		quantidade  -> n�mero de �tens

opcoes
	0
		codigo -> 1 ou 2 d�gitos
		*vide valores espec�ficos para cada modalidade de frete
	

Como resposta a loja requisitante ter� um XML no seguinte formato:
<fretes>
	<pac>
		<erro>0</erro>
		<nome>Pac</nome>
		<valor>1000</valor>
		<prazo>10</prazo>
		<codido>1</codigo>
	</pac>
	<expresso>
		<erro>0</erro>
		<nome>JadLog Expresso</nome>
		<valor>1500</valor>
		<prazo>5</prazo>
		<codido>2</codigo>
	</expresso>
	<sedex>
		<erro>101</erro>
		<nome>Sedex</nome>
	</sedex>
</fretes>

Onde:
erro   = Se igual � 0, indica que n�o houveram erros na transa��o
nome   = nome do tipo de frete em quest�o
codigo = C�digo que representa o tipo de frete no webservice
valor  = Pre�o em centavos sem virgulas do frete
prazo  = Tempo em dias que ap�s a emiss�o ser� levado para entrega

Obs.: Para verificar os erros poss�veis vide o arquivo tabela_erros.xls


Valores para consulta JadLog
============================

modalidade    -> Modalidade do frete. Deve conter apenas n�meros
seguro        -> Tipo do Seguro 'N' normal 'A' ap�lice pr�pria
valor_coleta  -> Valor da coleta negociado com a unidade JADLOG. em centavos sem
                 casas decimais
pagar_destino -> Frete a pagar no destino, 'S' = sim 'N' = n�o.
tipo_entrega  -> Tipo de entrega 'R' retira unidade JADLOG, 'D' domicilio.

Valores para consulta Correios
==============================

formato                 -> (1 ou 2) 1 - caixa | 2 - prisma
servico_adicional       -> S ou N
valor_servico_adicional -> se servico_adicional = 'S' ent�o deve ser declarado 
                           valor do servi�o em centavos sem casas decimais
aviso_recebimetno       -> S ou N

