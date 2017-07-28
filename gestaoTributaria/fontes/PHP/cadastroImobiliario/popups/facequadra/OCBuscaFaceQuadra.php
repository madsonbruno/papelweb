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
    * Página de processamento oculto para o cadastro de face de quadra
    * Data de Criação   : 13/08/2004

    * @author Analista: Ricardo Lopes de Alencar
    * @author Desenvolvedor: Gustavo Passos Tourinho

    * @ignore

    * $Id: OCBuscaFaceQuadra.php 59612 2014-09-02 12:00:51Z gelson $

    * Casos de uso: uc-05.01.07
*/

/*
$Log$
Revision 1.4  2006/09/15 15:04:05  fabio
correção do cabeçalho,
adicionado trecho de log do CVS

*/
    include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
    include_once(CAM_MAPEAMENTO."TAtributoNivel.class.php");
    include_once(CAM_MAPEAMENTO."TNivel.class.php");
    include_once(CAM_MAPEAMENTO."TNivelSuperior.class.php");
    include_once(CAM_MAPEAMENTO."TLocalizacao.class.php");
    include_once(CAM_INTERFACE."MontaLocalizacao.class.php");

    $stCtrl = $_GET['stCtrl'] ?  $_GET['stCtrl'] : $_POST['stCtrl'];

    switch ($stCtrl) {
        // preenche combos de LOCALIZACAO
        case "buscaValoresNiveis":
            $obMontaLocalizacao = new MontaLocalizacao;
            $obMontaLocalizacao->setName  ('inCodLocalizacao_' );
            $obMontaLocalizacao->setIFrame( true );
            $obMontaLocalizacao->buscaValoresLocalizacao();
        break;

        case "preencheCombos":
            $obMontaLocalizacao = new MontaLocalizacao;
            $obMontaLocalizacao->setName  ('inCodLocalizacao_' );
            $obMontaLocalizacao->setIFrame( true );
            $obMontaLocalizacao->preencheLocalizacao();
        break;
    }
?>