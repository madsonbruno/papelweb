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
    * Classe de mapeamento da tabela STN.RECURSO_FUNDEB
    * Data de Criação: 07/05/2008

    * @author Analista: Tonismar Regis Bernardo
    * @author Desenvolvedor: Leopoldo Braga Barreiro

    $Revision: $
    $Name$
    $Author: $
    $Date: $

    * Casos de uso:

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CLA_PERSISTENTE );

class TSTNRecursoFundeb extends Persistente
{
/**
    * Método Construtor
    * @access Private
*/
function TSTNRecursoFundeb()
{
    parent::Persistente();

    $this->setTabela('stn.recurso_fundeb');

    $this->setCampoCod('');
    $this->setComplementoChave('exercicio,cod_recurso');

    $this->AddCampo( 'exercicio'    ,'char'   ,true , '04',true ,true  );
    $this->AddCampo( 'cod_recurso'  ,'integer',true ,   '',true ,true  );

}

function recuperaRelacionamento()
{
    $obErro      = new Erro;
    $obConexao   = new Conexao;
    $rsRecordSet = new RecordSet;

    $stSql = $this->montaRecuperaRelacionamento();
    $this->setDebug( $stSql );
    $obErro = $obConexao->executaSQL( $rsRecordSet, $stSql, $boTransacao );

    return $obErro;
}

function montaRecuperaRelacionamento()
{
    $stSql = " 	SELECT
                    ore.*
                FROM
                    orcamento.recurso ore
                    INNER JOIN
                    stn.recurso_fundeb rf ON
                        rf.exercicio = ore.exercicio AND
                        rf.cod_recurso = ore.cod_recurso
                WHERE true ";
    if ($this->getDado("'exercicio")) {
        $stSql .= " AND ore.exercicio = '" . $this->getDado("exercicio") . "' ";
    }

    if ($this->getDado("cod_recurso")) {
        $stSql .= " AND ore.cod_recurso = " . $this->getDado("cod_recurso") . " ";
    }

    $stSql = str_replace(array("\n", "\t", "\r"), array("", "", ""), $stSql);

    return $stSql;

}

function montaRecuperaTodos()
{
    $stSql = "	SELECT
                    *
                FROM
                    stn.recurso_fundeb rf ";

    $stSql = str_replace(array("\n", "\t", "\r"), array("", "", ""), $stSql);

    return $stSql;
}

function excluiPorExercicio($boTransacao="")
{
    $obErro = new Erro;
    $obConexao = new Conexao;

    if ($this->getDado("exercicio")) {
        $obErro = $obConexao->executaDML($this->montaExcluiPorExercicio(), $boTransacao);
    } else {
        $obErro->setDescricao("O exercício deve estar definido para limpar os dados.");
    }

    return $obErro;

}

function montaExcluiPorExercicio()
{
    $stSql = "	DELETE FROM " . $this->getTabela() . " WHERE exercicio = '" . $this->getDado("exercicio") . "' ";

    return $stSql;
}

}
?>
