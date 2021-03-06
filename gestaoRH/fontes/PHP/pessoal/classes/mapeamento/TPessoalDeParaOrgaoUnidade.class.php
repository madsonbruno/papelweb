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
    * Classe de mapeamento da tabela pessoal.de_para_orgao_unidade
    * Data de Criação: 20/07/2009

    * @author Analista      Tonismar Régis Bernardo <tonismar.bernardo@cnm.org.br>
    * @author Desenvolvedor Henrique Girardi dos Santos <henrique.santos@cnm.org.br>

    * @package URBEM
    * @subpackage

    $Id:$
*/

require_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
require_once CLA_PERSISTENTE;

class TPessoalDeParaOrgaoUnidade extends Persistente
{

    /**
     * Método Construtor da classe de mapeamento
     *
     * @author Analista      Tonismar Régis Bernardo <tonismar.bernardo@cnm.org.br>
     * @author Desenvolvedor Henrique Girardi dos Santos <henrique.santos@cnm.org.br>
     *
     * @return void
    */
    public function __construct()
    {
        parent::Persistente();
        $this->setTabela('pessoal.de_para_orgao_unidade');

        $this->setCampoCod('cod_orgao');
        $this->setComplementoChave('num_orgao, num_unidade, exercicio');

        $this->AddCampo('cod_orgao'  , 'integer', true, '' , true , true);
        $this->AddCampo('num_orgao'  , 'integer', true, '' , false, true);
        $this->AddCampo('num_unidade', 'integer', true, '' , false, true);
        $this->AddCampo('exercicio'  , 'char'   , true, '4', false, true);
    }

}
