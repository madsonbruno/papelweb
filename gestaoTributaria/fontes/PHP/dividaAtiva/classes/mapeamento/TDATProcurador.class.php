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
    * Classe de mapeamento da tabela DIVIDA.PROCURADOR
    * Data de Criação: 14/09/2006

    * @author Analista: Fabio Bertoldi Rodrigues
    * @author Desenvolvedor: Fernando Piccini Cercato
    * @package URBEM
    * @subpackage Mapeamento

    * $Id: TDATProcurador.class.php 59612 2014-09-02 12:00:51Z gelson $

* Casos de uso: uc-05.04.08
*/

/*
$Log$
Revision 1.3  2006/10/05 15:07:48  dibueno
Alterações nas colunas da tabela

Revision 1.2  2006/09/22 09:59:49  cercato
correcao do caso de uso.

Revision 1.1  2006/09/18 17:19:17  cercato
classes de mapeamento para as tabelas "autoridade" e "procurador".

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
//include_once    ( CLA_PERSISTENTE );

class TDATProcurador extends Persistente
{
    /**
        * Método Construtor
        * @access Private
    */
    public function TDATProcurador()
    {
        parent::Persistente();
        $this->setTabela('divida.procurador');

        $this->setCampoCod('cod_autoridade');
        $this->setComplementoChave('');

        $this->AddCampo('cod_autoridade','integer',true,'',true,true);
        $this->AddCampo('oab','varchar',true,'10',false,false);
        $this->AddCampo('cod_uf','integer',true,'',false,true);
    }

}// end of class
?>
