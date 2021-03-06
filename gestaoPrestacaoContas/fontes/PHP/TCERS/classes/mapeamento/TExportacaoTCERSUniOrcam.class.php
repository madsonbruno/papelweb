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
    * Classe de mapeamento da tabela FN_ExportacaoTCERS_EXPORTACAO_BALANCETE_RECEITA
    * Data de Criação: 10/02/2005

    * @author Analista: Diego Barbosa Victoria
    * @author Desenvolvedor: Cleisson Barboza

    * @package URBEM
    * @subpackage Mapeamento

    $Revision: 59612 $
    $Name$
    $Author: gelson $
    $Date: 2014-09-02 09:00:51 -0300 (Tue, 02 Sep 2014) $

    * Casos de uso: uc-02.08.05
*/

/*
$Log$
Revision 1.1  2007/09/24 20:03:20  hboaventura
Ticket#10234#

Revision 1.13  2006/07/05 20:45:58  cleisson
Adicionada tag Log aos arquivos

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CLA_PERSISTENTE );

class TExportacaoTCERSUniOrcam extends Persistente
{
function TExportacaoTCERSUniOrcam()
{
    parent::Persistente();
    $this->setTabela('tcers.uniorcam');
    $this->setComplementoChave('exercicio,num_unidade,num_orgao');

    $this->AddCampo('exercicio','varchar',true,'4',true,true);
    $this->AddCampo('num_unidade','integer',true,'',true,true);
    $this->AddCampo('num_orgao','integer',true,'',true,true);
    $this->AddCampo('numcgm','integer',true,'',false,true);
    $this->AddCampo('identificador','integer',true,'',false,false);
}

    /**
        * Executa um Select no banco de dados a partir do comando SQL montado no método montaRecuperaDadosExportacao.
        * @access Public
        * @param  Object  $rsRecordSet Objeto RecordSet
        * @param  String  $stCondicao  String de condição do SQL (WHERE)
        * @param  String  $stOrdem     String de Ordenação do SQL (ORDER BY)
        * @param  Boolean $boTransacao
        * @return Object  Objeto Erro
    */
    public function recuperaDadosUniOrcam(&$rsRecordSet, $stCondicao = "" , $stOrdem = "" , $boTransacao = "")
    {
        $obErro      = new Erro;
        $obConexao   = new Conexao;
        $rsRecordSet = new RecordSet;

        if(trim($stOrdem))
            $stOrdem = (strpos($stOrdem,"ORDER BY")===false)?" ORDER BY $stOrdem":$stOrdem;
        $stSql = $this->MontaRecuperaDadosUniOrcam().$stCondicao.$stOrdem;
        $this->setDebug( $stSql );
        $obErro = $obConexao->executaSQL( $rsRecordSet, $stSql, $boTransacao );

        return $obErro;
    }

    public function MontaRecuperaDadosUniOrcam()
    {
        $stSql  = "";
        $stSql .= "SELECT                                                           \n";
        $stSql .= "     oo.nom_orgao,                                               \n";
        $stSql .= "     oo.num_orgao,                                               \n";
        $stSql .= "     ou.nom_unidade,                                             \n";
        $stSql .= "     ou.num_unidade,                                             \n";
        $stSql .= "     tu.identificador,                                           \n";
        $stSql .= "     tu.numcgm                                                   \n";
        $stSql .= "FROM                                                             \n";
        $stSql .= "     orcamento.orgao     as oo,                              \n";
        $stSql .= "     orcamento.unidade   as ou                               \n";
        $stSql .= "LEFT JOIN                                                        \n";
        $stSql .= "     tcers.uniorcam      as tu                               \n";
        $stSql .= "ON                                                               \n";
        $stSql .= "         ou.exercicio        = tu.exercicio                      \n";
        $stSql .= "     and ou.num_unidade      = tu.num_unidade                    \n";
        $stSql .= "     and ou.num_orgao        = tu.num_orgao                      \n";
        $stSql .= "WHERE                                                            \n";
        $stSql .= "         oo.num_orgao = ou.num_orgao                             \n";
        $stSql .= "     and oo.exercicio = ou.exercicio                             \n";
        $stSql .= "     and oo.exercicio        = '".$this->getDado("exercicio")."' \n";

        return $stSql;
    }

    /**
        * Executa um Select no banco de dados a partir do comando SQL montado no método montaRecuperaDadosExportacao.
        * @access Public
        * @param  Object  $rsRecordSet Objeto RecordSet
        * @param  String  $stCondicao  String de condição do SQL (WHERE)
        * @param  String  $stOrdem     String de Ordenação do SQL (ORDER BY)
        * @param  Boolean $boTransacao
        * @return Object  Objeto Erro
    */
    public function recuperaDadosUniOrcamConversao(&$rsRecordSet, $stCondicao = "" , $stOrdem = "" , $boTransacao = "")
    {
        $obErro      = new Erro;
        $obConexao   = new Conexao;
        $rsRecordSet = new RecordSet;

        if(trim($stOrdem))
            $stOrdem = (strpos($stOrdem,"ORDER BY")===false)?" ORDER BY $stOrdem":$stOrdem;
        $stSql = $this->MontaRecuperaDadosUniOrcamConversao().$stCondicao.$stOrdem;
        $this->setDebug( $stSql );
        $obErro = $obConexao->executaSQL( $rsRecordSet, $stSql, $boTransacao );

        return $obErro;
    }

    public function MontaRecuperaDadosUniOrcamConversao()
    {
        $stSql  = "";
        $stSql .= "SELECT DISTINCT                                                  \n";
        $stSql .= "     ee.exercicio,                                               \n";
        $stSql .= "     ee.num_orgao,                                               \n";
        $stSql .= "     ee.num_unidade,                                             \n";
        $stSql .= "     tu.identificador,                                           \n";
        $stSql .= "     tu.numcgm                                                   \n";
        $stSql .= "FROM                                                             \n";
        $stSql .= "     empenho.restos_pre_empenho as ee                        \n";
        $stSql .= "LEFT JOIN                                                        \n";
        $stSql .= "     tcers.uniorcam      as tu                               \n";
        $stSql .= "ON                                                               \n";
        $stSql .= "         ee.exercicio        = tu.exercicio                      \n";
        $stSql .= "     and ee.num_unidade      = tu.num_unidade                    \n";
        $stSql .= "     and ee.num_orgao        = tu.num_orgao                      \n";
        $stSql .= "UNION                                                            \n";
        $stSql .= "SELECT                                                           \n";
        $stSql .= "     '2004' as exercicio,                                        \n";
        $stSql .= "     oo.num_orgao,                                               \n";
        $stSql .= "     ou.num_unidade,                                             \n";
        $stSql .= "     tu.identificador,                                           \n";
        $stSql .= "     tu.numcgm                                                   \n";
        $stSql .= "FROM                                                             \n";
        $stSql .= "     orcamento.orgao     as oo,                              \n";
        $stSql .= "     orcamento.unidade   as ou                               \n";
        $stSql .= "LEFT JOIN                                                        \n";
        $stSql .= "     tcers.uniorcam      as tu                               \n";
        $stSql .= "ON                                                               \n";
        $stSql .= "         ou.exercicio        = tu.exercicio                      \n";
        $stSql .= "     and ou.num_unidade      = tu.num_unidade                    \n";
        $stSql .= "     and ou.num_orgao        = tu.num_orgao                      \n";
        $stSql .= "WHERE                                                            \n";
        $stSql .= "         oo.num_orgao = ou.num_orgao                             \n";
        $stSql .= "     and oo.exercicio = ou.exercicio                             \n";
        $stSql .= "     and oo.exercicio        = '2005'                            \n";

        $stSql .= "UNION                                                            \n";
        $stSql .= "SELECT                                                           \n";
        $stSql .= "     oo.exercicio,                                               \n";
        $stSql .= "     oo.num_orgao,                                               \n";
        $stSql .= "     ou.num_unidade,                                             \n";
        $stSql .= "     tu.identificador,                                           \n";
        $stSql .= "     tu.numcgm                                                   \n";
        $stSql .= "FROM                                                             \n";
        $stSql .= "     orcamento.orgao     as oo,                                  \n";
        $stSql .= "     orcamento.unidade   as ou                                   \n";
        $stSql .= "LEFT JOIN                                                        \n";
        $stSql .= "     tcers.uniorcam      as tu                                   \n";
        $stSql .= "ON                                                               \n";
        $stSql .= "         ou.exercicio        = tu.exercicio                      \n";
        $stSql .= "     and ou.num_unidade      = tu.num_unidade                    \n";
        $stSql .= "     and ou.num_orgao        = tu.num_orgao                      \n";
        $stSql .= "WHERE                                                            \n";
        $stSql .= "         oo.num_orgao = ou.num_orgao                             \n";
        $stSql .= "     and oo.exercicio = ou.exercicio                             \n";
        $stSql .= "     and oo.exercicio       < '".$this->getDado("exercicio")."'  \n";

        return $stSql;
    }

}
