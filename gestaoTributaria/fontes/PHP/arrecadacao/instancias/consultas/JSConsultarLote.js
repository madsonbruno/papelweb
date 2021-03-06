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
<?
/**
    * Arquivo com funcoes JavaScript para Consulta de Arrecadacao
    * Data de Criação: 09/06/2005


    * @author Analista: Fabio Bertoldi
    * @author Desenvolvedor: Lucas Teixeira Stephanou

    * @ignore

    * $Id: JSConsultarLote.js 62838 2015-06-26 13:02:49Z diogo.zarpelon $

    * Casos de uso: uc-05.03.19
*/

/*
$Log$
Revision 1.3  2007/05/02 18:27:33  cercato
Bug #9138#

Revision 1.2  2006/09/15 11:04:44  fabio
correção do cabeçalho,
adicionado trecho de log do CVS

*/

?>
<script type="text/javascript">

function CancelarCL(){
<?php
    $link = Sessao::read( "link" );
    $stLink = "&pg=".$link["pg"]."&pos=".$link["pos"];
?>
    mudaTelaPrincipal("<?=$pgList.'?'.Sessao::getId().$stLink;?>");
}


function Limpar(){
    document.frm.reset();
}

function buscaValor(tipoBusca){
    document.frm.stCtrl.value = tipoBusca;
    document.frm.target = 'oculto';
    document.frm.action = '<?=$pgOcul;?>?<?=Sessao::getId();?>';
    document.frm.submit();
    document.frm.target = 'telaPrincipal';
    document.frm.action = '<?=$pgList;?>?<?=Sessao::getId();?>';
}

function preencheAgencia(){
    var stTraget = document.frm.target;
    var stAction = document.frm.action;
    document.frm.stCtrl.value = 'preencheAgencia';
    document.frm.target = "oculto";
    document.frm.action = '<?=$pgOcul;?>?<?=Sessao::getId();?>';
    document.frm.submit();
    document.frm.target = stTraget;
    document.frm.action = stAction;
}

function validaData1500( CampoData ) {
    
    dtDataCampo = CampoData.value;
    DiaData          = dtDataCampo.substring(0,2);
    MesData         = dtDataCampo.substring(3,5);
    AnoData         = dtDataCampo.substr(6);

    var dataValidar = 15000422;
    var dataCampoInvert = AnoData+MesData+DiaData;

    if( dataCampoInvert < dataValidar ){
        CampoData.value = "";
        erro = true;
        var mensagem = "";
        mensagem += "@Campo Data deve ser posterior a 21/04/1500!";
        alertaAviso(mensagem,'form','erro','<?=Sessao::getId();?>', '../');
    }

}
</script>
