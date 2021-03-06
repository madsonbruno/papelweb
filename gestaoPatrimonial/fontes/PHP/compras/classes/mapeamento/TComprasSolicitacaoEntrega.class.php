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
    * Classe de mapeamento da tabela compras.solicitacao_entrega
    * Data de Criação: 14/09/2006

    * @author Analista: Gelson W. Gonçalves
    * @author Desenvolvedor: Nome do Programador

    * @package URBEM
    * @subpackage Mapeamento

    $Revision: 17467 $
    $Name$
    $Author: larocca $
    $Date: 2006-11-07 14:41:27 -0200 (Ter, 07 Nov 2006) $

    * Casos de uso: uc-03.04.01
*/
/*
$Log$
Revision 1.2  2006/11/07 16:41:27  larocca
Inclusão dos Casos de Uso

Revision 1.1  2006/09/14 16:32:08  cleisson
inclusão

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CLA_PERSISTENTE );

/**
  * Efetua conexão com a tabela  compras.solicitacao_entrega
  * Data de Criação: 14/09/2006

  * @author Analista: Gelson W. Gonçalves
  * @author Desenvolvedor: Nome do Programador

  * @package URBEM
  * @subpackage Mapeamento
*/
class TComprasSolicitacaoEntrega extends Persistente
{
/**
    * Método Construtor
    * @access Private
*/
function TComprasSolicitacaoEntrega()
{
    parent::Persistente();
    $this->setTabela("compras.solicitacao_entrega");

    $this->setCampoCod('');
    $this->setComplementoChave('exercicio,cod_entidade,cod_solicitacao');

    $this->AddCampo('exercicio'      ,'char'   ,false ,true,'4'  ,true,'TComprasSolicitacao');
    $this->AddCampo('cod_entidade'   ,'integer',false ,true,''   ,true,'TComprasSolicitacao');
    $this->AddCampo('cod_solicitacao','integer',false ,true,''   ,true,'TComprasSolicitacao');
    $this->AddCampo('numcgm'         ,'integer',false ,true,''   ,false,'TCGMCGM');

}
}
