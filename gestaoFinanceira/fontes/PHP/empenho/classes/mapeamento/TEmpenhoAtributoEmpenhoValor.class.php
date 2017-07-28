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
    * Classe de mapeamento da tabela EMPENHO.ATRIBUTO_EMPENHO_VALOR
    * Data de Criação: 03/12/2004

    * @author Analista: Jorge B. Ribarr
    * @author Desenvolvedor: Diego Barbosa Victoria

    * @package URBEM
    * @subpackage Mapeamento

    $Revision: 30668 $
    $Name$
    $Author: cleisson $
    $Date: 2006-07-05 17:51:50 -0300 (Qua, 05 Jul 2006) $

    * Casos de uso: uc-02.03.03
*/

/*
$Log$
Revision 1.10  2006/07/05 20:46:56  cleisson
Adicionada tag Log aos arquivos

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
//include_once    ( CAM_GF_EMP_MAPEAMENTO . "TEmpenhoAtributoEmpenho.class.php");
include_once ( CLA_PERSISTENTE_ATRIBUTOS_VALORES );

/**
  * Efetua conexão com a tabela  EMPENHO.ATRIBUTO_EMPENHO_VALOR
  * Data de Criação: 03/12/2004

  * @author Analista: Jorge B. Ribarr
  * @author Desenvolvedor: Diego Barbosa Victoria

  * @package URBEM
  * @subpackage Mapeamento
*/
class TEmpenhoAtributoEmpenhoValor extends PersistenteAtributosValores
{
/**
    * Método Construtor
    * @access Private
*/
function TEmpenhoAtributoEmpenhoValor()
{
    parent::PersistenteAtributosValores();
    $this->setTabela('empenho.atributo_empenho_valor');
    //$this->setPersistenteAtributo( new TEmpenhoAtributoEmpenho() );

    $this->setCampoCod('cod_pre_empenho');
    $this->setComplementoChave('cod_atributo,exercicio,cod_cadastro,cod_modulo');

    $this->AddCampo('cod_pre_empenho','integer'     ,true ,'',true,true);
    $this->AddCampo('cod_atributo'   ,'integer'     ,true ,'',true,true);
    $this->AddCampo('cod_cadastro'   ,'integer'     ,true ,'',true,true);
    $this->AddCampo('exercicio'      ,'varchar'     ,true ,'',true,true);
    $this->AddCampo('timestamp'      ,'timestamp'   ,false,'',true,true);
    $this->AddCampo('valor'          ,'text'        ,true ,'',false,false);
    $this->AddCampo('cod_modulo'     ,'integer'     ,true ,'',false,false);

}
}
