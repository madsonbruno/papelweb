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
    * Classe de mapeamento da tabela compras.compra_direta
    * Data de Criação: 30/01/2007

    * @author Analista: Gelson
    * @author Desenvolvedor: Henrique Boaventura

    * @package URBEM
    * @subpackage Mapeamento

    $Revision: 59612 $
    $Name$
    $Author: gelson $
    $Date: 2014-09-02 09:00:51 -0300 (Tue, 02 Sep 2014) $

    * Casos de uso: uc-06.04.00
*/

/*
$Log$
Revision 1.3  2007/06/12 20:44:11  hboaventura
inclusão dos casos de uso uc-06.04.00

Revision 1.2  2007/06/12 18:34:05  hboaventura
inclusão dos casos de uso uc-06.04.00

Revision 1.1  2007/05/15 19:02:57  hboaventura
Arquivos para geração do TCMGO

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CLA_PERSISTENTE );

class TTGOBalancoPfraaaa extends Persistente
{
    /**
    * Método Construtor
    * @access Private
*/
    public function TTGOBalancoPfraaaa()
    {
        parent::Persistente();
        $this->setTabela("tcmgo.balanco_pfraaaa");

        $this->setCampoCod('cod_conta');
        $this->setComplementoChave('exercicio');

        $this->AddCampo( 'cod_conta' ,'integer' ,true, ''   ,true ,true  );
        $this->AddCampo( 'exercicio' ,'char' ,true, '4'   ,true ,true  );
        $this->AddCampo( 'tipo_lancamento' ,'integer' ,true, '' ,false ,false );
    }

    public function recuperaRelacionamento(&$rsRecordSet,$stFiltro="",$stOrder="",$boTransacao="")
    {
        return $this->executaRecupera("montaRecuperaRelacionamento",$rsRecordSet,$stFiltro,$stOrder,$boTransacao);
    }
    public function montaRecuperaRelacionamento()
    {
        $stSql = "
            SELECT  conta_despesa.cod_conta
                 ,  descricao
                 ,  cod_estrutural
                 ,  tipo_lancamento
              FROM  orcamento.conta_despesa
         LEFT JOIN  tcmgo.balanco_pfraaaa
                ON  balanco_pfraaaa.cod_conta = conta_despesa.cod_conta
               AND  balanco_pfraaaa.exercicio = conta_despesa.exercicio
             WHERE  conta_despesa.exercicio = '".$this->getDado('exercicio')."' ";
        if ( $this->getDado('tipo_lancamento') ) {
            $stSql.= " AND  balanco_pfraaaa.tipo_lancamento = ".$this->getDado('tipo_lancamento')." ";
        }
        if ( $this->getDado('cod_conta') ) {
            $stSql.= " AND  balanco_pfraaaa.cod_conta = ".$this->getDado('cod_conta')." ";
        }
        $stSql.= " ORDER BY cod_estrutural ";

        return $stSql;
    }

}
