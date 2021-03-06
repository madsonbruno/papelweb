<?php
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
?>
<?php
/**
 * Página de Oculto de Manter Escola
 * Data de Criação: 15/04/2014

 * @author Analista:      Gelson Wolowski
 * @author Desenvolvedor: Lisiane Morais>

 * @ignore

 $Id: OCManterEscola.php 57866 2014-04-15 16:00:07Z lisiane $

 */

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once( CAM_GP_FRO_MAPEAMENTO."TFrotaEscola.class.php" );
include_once( CAM_GP_FRO_MAPEAMENTO."TFrotaTurno.class.php" );
include_once( CAM_GP_FRO_MAPEAMENTO."TFrotaVeiculo.class.php" );
include_once( CAM_GP_FRO_MAPEAMENTO."TFrotaTransporteEscolar.class.php" );

//Define o nome dos arquivos PHP
$stPrograma = "ManterTransporteEscolar";
$pgFilt     = "FL".$stPrograma.".php";
$pgList     = "LS".$stPrograma.".php";
$pgForm     = "FM".$stPrograma.".php";
$pgProc     = "PR".$stPrograma.".php";
$pgOcul     = "OC".$stPrograma.".php";
$pgJs       = "JS".$stPrograma.".js";


$stCtrl = $_REQUEST['stCtrl'];

switch ($stCtrl) {
    case 'verificaEscola':
        $inCgmEscola = $request->get('inCgmEscola');
        
        if($inCgmEscola != ""){
            $obTFrotaEscola = new TFrotaEscola;
            $obTFrotaEscola->setDado('numcgm',$inCgmEscola);
            $obTFrotaEscola->recuperaPorChave($rsFrotaEscola);
         
            if($rsFrotaEscola->getNumLinhas() > 0){
                if($rsFrotaEscola->getCampo('ativo') == 'f'){
                    $stJs .= "jQuery('#ok').attr('disabled','disabled');\n";
                    $stJs .= "alertaAviso('@CGM Escola: ".$inCgmEscola." não está ativa!','form','erro','".Sessao::getId()."');"."\n";
                } else {
                    $stJs .= "jQuery('#ok').removeAttr('disabled');\n";
                }
            }
        }
    break;
}

if (!empty($stJs)) {
    echo $stJs;
}

?>