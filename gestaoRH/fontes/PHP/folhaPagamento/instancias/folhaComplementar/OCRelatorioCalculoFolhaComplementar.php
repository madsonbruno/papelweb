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
    * Oculto para geração do recordset do relatório
    * Data de Criação: 31/01/2006

    * @author Analista: Vandré Miguel Ramos
    * @author Desenvolvedor: Diego Lemos de Souza

    * @ignore

    $Revision: 30766 $
    $Name$
    $Author: vandre $
    $Date: 2006-08-08 14:53:12 -0300 (Ter, 08 Ago 2006) $

    * Casos de uso: uc-04.05.10
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CAM_FW_PDF."RRelatorio.class.php"                                                        );
include_once ( CAM_GRH_FOL_NEGOCIO."RRelatorioCalculoFolhaComplementar.class.php"                          );

$obRRelatorio                      = new RRelatorio;
$obRRelatorioCalculoFolhaComplementar = new RRelatorioCalculoFolhaComplementar;
$rsRecordset                       = new Recordset;
$rsContratos = ( is_object(Sessao::read('rsContratos')) ) ? Sessao::read('rsContratos') : new recordset;
$stContratos = "";
while (!$rsContratos->eof()) {
    $stContratos .= $rsContratos->getCampo('contrato').",";
    $rsContratos->proximo();
}
$stContratos = substr($stContratos,0,strlen($stContratos)-1);
$obRRelatorioCalculoFolhaComplementar->obRFolhaPagamentoPeriodoMovimentacao->addRFolhaPagamentoPeriodoContratoServidor();
$obRRelatorioCalculoFolhaComplementar->obRFolhaPagamentoPeriodoMovimentacao->roRFolhaPagamentoPeriodoContratoServidor->setRegistro($stContratos);
$obRRelatorioCalculoFolhaComplementar->geraRecordSet( $rsRecordset );
Sessao::write("rsErros",$rsRecordset);
$obRRelatorio->executaFrameOculto( "OCGeraRelatorioCalculoFolhaComplementar.php" );
?>
