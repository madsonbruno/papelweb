<script type="text/javascript">
/*
    **********************************************************************************
    *                                                                                *
    * @package URBEM CNM - Soluções em Gestão Pública                                *
    * @copyright (c) 2013 Confederação Nacional de Municípos                         *
    * @author Confederação Nacional de Municípios                                    *
    *                                                                                *
    * O URBEM CNM é um software livre; você pode redistribuí-lo e/ou modificá-lo sob *
    * os  termos  da Licença Pública Geral GNU conforme  publicada  pela Fundação do *
    * Software Livre (FSF - Free Software Foundation); na versão 2 da Licença.       *
    *                                                                                *
    * Este  programa  é  distribuído  na  expectativa  de  que  seja  útil,   porém, *
    * SEM NENHUMA GARANTIA; nem mesmo a garantia implícita  de  COMERCIABILIDADE  OU *
    * ADEQUAÇÃO A UMA FINALIDADE ESPECÍFICA. Consulte a Licença Pública Geral do GNU *
    * para mais detalhes.                                                            *
    *                                                                                *
    * Você deve ter recebido uma cópia da Licença Pública Geral do GNU "LICENCA.txt" *
    * com  este  programa; se não, escreva para  a  Free  Software Foundation  Inc., *
    * no endereço 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.       *
    *                                                                                *
    **********************************************************************************
*/
</script>
<?php
/**
    * Arquivo JavaScript
    * Data de Criação   : 06/01/2006


    * @author Analista: Lucas Leusin Oaigen
    * @author Desenvolvedor: Lucas Leusin Oaigen

    * @ignore
    
    $Revision: 30668 $
    $Name$
    $Autor:$
    $Date: 2006-07-05 17:51:50 -0300 (Qua, 05 Jul 2006) $
    
    * Casos de uso: uc-02.04.07

*/

/*
$Log$
Revision 1.2  2006/07/05 20:39:48  cleisson
Adicionada tag Log aos arquivos

*/
?>
<script type="text/javascript">

function trocaObrigatoriedade(valor){
    if(valor == 'caixa'){   
        document.getElementById('rotuloTerminal').innerHTML = '*Nr. Terminal de Caixa';
        document.frm.stEval.value = 'stCampo = document.frm.inCodTerminal; if( !isInt( stCampo.value ) ){ erro = true; mensagem += \'@Campo Nr. Terminal de Caixa inválido!(\'+stCampo.value+\')\';   }  stCampo = document.frm.inCodTerminal;  if( trim( stCampo.value ) == \'\' ){  erro = true;   mensagem += \'@Campo Nr. Terminal de Caixa inválido!()\';    }    ';
    }else if (valor == 'boletim'){
        document.getElementById('rotuloTerminal').innerHTML = 'Nr. Terminal de Caixa';
        document.frm.stEval.value = '';
    } 
}

</script>
                
