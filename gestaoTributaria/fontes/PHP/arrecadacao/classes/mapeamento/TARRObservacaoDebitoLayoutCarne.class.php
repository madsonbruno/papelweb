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
    * Classe de mapeamento da tabela ARRECADACAO.OBSERVACAO_DEBITO_LAYOUT_CARNE
    * Data de Criação: 17/12/2008

    * @author Analista: Fabio Bertoldi Rodrigues
    * @author Desenvolvedor: Fernando Piccini Cercato
    * @package URBEM
    * @subpackage Mapeamento

    * $Id: $

* Casos de uso: uc-05.03.01
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';

class TARRObservacaoDebitoLayoutCarne extends Persistente
{
    /**
        * Método Construtor
        * @access Private
    */
    public function TARRObservacaoDebitoLayoutCarne()
    {
        parent::Persistente();
        $this->setTabela( 'arrecadacao.observacao_debito_layout_carne' );

        $this->setCampoCod( '' );
        $this->setComplementoChave( 'cod_modelo' );

        $this->AddCampo( 'cod_modelo', 'integer', true, '', true, true );
        $this->AddCampo( 'observacao_devedor', 'varchar', true, '100', false, false );
        $this->AddCampo( 'observacao_nao_devedor', 'varchar', true, '100', false, false );
    }

}
?>
