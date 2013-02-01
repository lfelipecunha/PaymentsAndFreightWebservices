<form action="index.php" method="POST" target="result">
    <fieldset>
        <legend>Loja</legend>
        <label>Email</label>
        <input type="text" name="loja[email]" value="financeiro@f1solucoes.com.br"/><br/>
        <label>Token</label>
        <input type="text" name="loja[token]" value="0045AAB1C3A723F1B6FB024C6BAA0642"/><br/>
        <label>ConsumerKey</label>
        <input type="text" name="loja[consumerKey]" value="dd3e9cd87b24d9afda41d7dc7633721f5a47e60e"/><br/>
    </fieldset>
    <fieldset>
        <legend>Comprador</legend>
        <label>Email</label>
        <input type="text" name="comprador[email]"/><br/>
        <label>Nome</label>
        <input type="text" name="comprador[nome]"/><br/>
        <label>CPF</label>
        <input type="text" name="comprador[cpf]"/><br/>
        <label>Telefone</label>
        <input type="text" name="comprador[telefone]"/><br/>
        <label>Genero</label>
        <input type="text" name="comprador[genero]"/><br/>
        <fieldset>
            <legend>Endereço</legend>
            <label>Logradouro</label>
            <input type="text" name="comprador[endereco][logradouro]"/><br/>
            <label>Número</label>
            <input type="text" name="comprador[endereco][numero]"/><br/>
            <label>Complemento</label>
            <input type="text" name="comprador[endereco][complemento]"/><br/>
            <label>Bairro</label>
            <input type="text" name="comprador[endereco][bairro]"/><br/>
            <label>Cidade</label>
            <input type="text" name="comprador[endereco][cidade]"/><br/>
            <label>Estado</label>
            <input type="text" name="comprador[endereco][estado]"/><br/>
            <label>CEP</label>
            <input type="text" name="comprador[endereco][cep]"/><br/>
        </fieldset>
    </fieldset>
    <fieldset>
        <legend>Frete</legend>
        <label>Nome</label>
        <input type="text" name="frete[nome]"/><br/>
        <label>Valor</label>
        <input type="text" name="frete[valor]"/><br/>
    </fieldset>
    <fieldset>
        <legend>Pagamento</legend>
        <label>Desconto</label>
        <input type="text" name="pagamento[desconto]"/><br/>
        <label>Acréscimo</label>
        <input type="text" name="pagamento[acrescimo]"/><br/>
        <label>Código</label>
        <input type="text" name="pagamento[codigo]"/><br/>
        <label>Parcelas</label>
        <input type="text" name="pagamento[parcelas]"/><br/>
        <fieldset>
            <legend>Cartão</legend>
            <label>Titular</label>
            <input type="text" name="pagamento[cartao][titular]"/><br/>
            <label>Número</label>
            <input type="text" name="pagamento[cartao][numero]"/><br/>
            <label>Código de Segurança</label>
            <input type="text" name="pagamento[cartao][codigoSeguranca]"/><br/>
            <label>Mês de Vencimento</label>
            <input type="text" name="pagamento[cartao][mesVencimento]"/><br/>
            <label>Ano de Vencimento</label>
            <input type="text" name="pagamento[cartao][anoVencimento]"/><br/>
        </fieldset>
    </fieldset>
    <fieldset>
        <legend>Produtos</legend>
        <fieldset>
            <legend>Produto</legend>
            <label>Código</label>
            <input type="text" name="produtos[0][codigo]"/><br/>
            <label>Nome</label>
            <input type="text" name="produtos[0][nome]"/><br/>
            <label>Quantidade</label>
            <input type="text" name="produtos[0][quantidade]"/><br/>
            <label>Valor</label>
            <input type="text" name="produtos[0][valor]"/><br/>
        </fieldset>
    </fieldset>
    <input type="submit" />
</form>
<iframe name="result" style="width: 100%; height: 300px;"></iframe>
