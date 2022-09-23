<?php
// Function: used to convert a string to revese in order
if (!  function_exists("reverse_string")) {
    function reverse_string(string $string)
    {
        return strrev($string);
    }
}

if (!  function_exists("debug")) {
    function debug($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        die;
    }
}

if(! function_exists("hidden")){
    function hidden($id, $valor = null){
        return '<input name="'.$id.'" value="'.$valor.'" id="'.$id.'" hidden>';
    }
}

if(! function_exists("switch_button")){
    function switch_button($rotulo, $id, $checked){
        $field = '<input name="'.$id.'" switch="dark" type="checkbox" '.($checked == true ? 'checked' : '').' id="'.$id.'">';
        $label = '<label class="form-label" for="'.$id.'" data-on-label="Sim" data-off-label="Não"></label>';
        return '<div class="row"><div class="col-11"><span>'.$rotulo.'</span></div><div class="col-1">'.$field.$label.'</div></div>';
    }
}

if (!  function_exists("input")) {
    // text
    // search
    // email
    // url
    // tel
    // password
    // number
    // datetime-local
    // date
    // month
    // week
    // time
    // color
    // datalist
    // select
    function input($rotulo, $id, $tamanho, $valor, $type, $array = null,  $opt = null)
    {
        switch ($type) {
            case 'datalist':
                $input = '<input name="'.$id.'" class="form-control form-control-sm" list="'.$id.'Options" value="'.$valor.'"  id="'.$id.'" '.$opt.'>';
                $options = "";
                foreach ($array as $key => $value) {
                    $options .= '<option value="'.$value['id'].'">'.$value['descricao'].'</option>';
                }
                $return = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$input.'<datalist id="'.$id.'Options">'.$options.'</datalist></div>';
                break;

            case 'select':
                $options = "";
                foreach ($array as $key => $value) {
                    $options .= '<option '.($valor == $value['id'] ? 'selected' : '').' value="'.$value['id'].'">'.$value['descricao'].'</option>';
                }
                $input = '<select name="'.$id.'" class="form-control form-control-sm">'.$options.'</select>';
                $return = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$input.'</div>';
                break;

            default:
                $field = '<input name="'.$id.'" class="form-control form-control-sm" type="'.$type.'" value="'.$valor.'" id="'.$id.'" '.$opt.'>';
                $input = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$field.'</div>';
                $return = $opt == 'hidden' ? $field : $input;
                break;
        }
        return $return;
    }
}

if(! function_exists("notificacao")){
    function notificacao($message){
        session()->setFlashdata('sucesso',$message);
    }
}

function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
    // Garante que o valor é uma string
    $digitos = (string) $digitos;
 
    // Faz a soma dos dígitos com a posição
    // Ex. para 10 posições:
    //   0    2    5    4    6    2    8    8   4
    // x10   x9   x8   x7   x6   x5   x4   x3  x2
    //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
    for ( $i = 0; $i < strlen($digitos); $i++  ) {
        // Preenche a soma com o dígito vezes a posição
        $soma_digitos = $soma_digitos + ( (int)$digitos[$i] * $posicoes );
        
        // Subtrai 1 da posição
        $posicoes--;
 
        // Parte específica para CNPJ
        // Ex.: 5-4-3-2-9-8-7-6-5-4-3-2
        if ( $posicoes < 2 ) {
            // Retorno a posição para 9
            $posicoes = 9;
        }
    }
 
    // Captura o resto da divisão entre soma_digitos dividido por 11
    // Ex.: 196 % 11 = 9
    $soma_digitos = $soma_digitos % 11;
    // Verifica se soma_digitos é menor que 2
    if ( $soma_digitos < 2 ) {
        // soma_digitos agora será zero
        $soma_digitos = 0;
    } else {
        // Se for maior que 2, o resultado é 11 menos soma_digitos
        // Ex.: 11 - 9 = 2
        // Nosso dígito procurado é 2
        $soma_digitos = 11 - $soma_digitos;
    }
    
    // Concatena mais um dígito aos primeiro nove dígitos
    // Ex.: 025462884 + 2 = 0254628842
    $cpf = $digitos.$soma_digitos;
 
    // Retorna
    return $cpf;
    
} // calc_digitos_posicoes

if(! function_exists("valida_cpf")){
    function valida_cpf($cpf){
        // Garante que o valor é uma string
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        
        // Captura os 9 primeiros dígitos do CPF
        // Ex.: 02546288423 = 025462884
        $digitos = substr($cpf, 0, 9);
        // debug($digitos);
    
        // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
        $novo_cpf = calc_digitos_posicoes( $digitos );
    
        // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
        $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
        // debug($novo_cpf);
        // Verifica se o novo CPF gerado é idêntico ao CPF enviado
        if ( $novo_cpf === $cpf ) {
            // CPF válido
            return true;
        } else {
            // CPF inválido
            return false;
        }
    }
}

if(!function_exists("valida_cnpj")){
    function validar_cnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;	

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}

if (!  function_exists("typeahead")) {
    function typeahead($rotulo, $id, $tamanho, $valor = null, $opt = null)
    {
        
        $field = '<input name="'.$id.'" class="typeahead form-control form-control-sm" type="text" value="'.$valor.'" id="'.$id.'" '.$opt.'>';
        $input = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$field.'</div>';
        $return = $opt == 'hidden' ? $field : $input;
        return $return;
    }
}

if(! function_exists("empresa")){
    function empresa($rotulo, $id, $tamanho, $valor){
        $field = '<input name="'.$id.'" class="form-control form-control-sm" type="text" value="'.$valor.'" id="'.$id.'"><a class="botao-interno" onclick="empresa()"><i class= "fas fa-search"></i></a>';
        $input = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$field.'</div>';
        return $input;
    }
}

if(! function_exists("empresa_multipla")){
    function empresa_multipla($rotulo, $id, $tamanho, $valor){
        $field = '<input name="'.$id.'" class="form-control form-control-sm" type="text" value="'.$valor.'" id="'.$id.'"><a class="botao-interno" onclick="empresa('.$id.')"><i class= "fas fa-search"></i></a>';
        $input = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$field.'</div>';
        return $input;
    }
}

if(! function_exists("unidade_de_negocio")){
    function unidade_de_negocio($rotulo, $id, $tamanho, $valor){
        $field = '<input name="'.$id.'" class="form-control form-control-sm" type="text" value="'.$valor.'" id="'.$id.'"><a class="botao-interno" onclick="unidade_de_negocio()"><i class= "fas fa-search"></i></a>';
        $input = '<div class="col-'.$tamanho.'"><label class="form-label">'.$rotulo.'</label>'.$field.'</div>';
        return $input;
    }
}