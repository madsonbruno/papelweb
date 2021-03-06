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
    * Pacote de configuração do TCEPE
    * Data de Criação   : 26/09/2014

    * @author Analista: Silvia Martins
    * @author Desenvolvedor: Lisiane Morais
    * 
    * $Id: TTCMGOConfiguracaoUnidadeGestora.class.php 65168 2016-04-29 16:36:09Z michel $
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once CAM_GA_ADM_MAPEAMENTO."TAdministracaoConfiguracaoEntidade.class.php";

class TTCMGOConfiguracaoUnidadeGestora extends TAdministracaoConfiguracaoEntidade
{
/**
    * Método Construtor
    * @access Private
*/
function __construct()
{
    parent::TAdministracaoConfiguracaoEntidade();
    $this->setDado("exercicio",Sessao::getExercicio());
    $this->setDado("cod_modulo",0); /*verificar número gerado pelos DBAs*/
}

function recuperaUnidadeGestora(&$rsRecordSet, $stFiltro = "", $stOrdem = "", $boTransacao = "")
{
    $obErro      = new Erro;
    $obConexao   = new Conexao;
    $rsRecordSet = new RecordSet;
    $stSql = $this->montaRecuperaUnidadeGestora().$stFiltro.$stOrdem;
    $this->stDebug = $stSql;
    $obErro = $obConexao->executaSQL( $rsRecordSet, $stSql, "", $boTransacao );
}

function montaRecuperaUnidadeGestora()
{
    $stSql = "  SELECT   entidade.cod_entidade
                     , sw_cgm.nom_cgm
                     , configuracao_entidade.valor
                FROM  sw_cgm
                INNER JOIN  orcamento.entidade
                     ON  entidade.numcgm = sw_cgm.numcgm
                LEFT JOIN  administracao.configuracao_entidade
                     ON  configuracao_entidade.exercicio    = entidade.exercicio
                    AND  configuracao_entidade.cod_entidade = entidade.cod_entidade
                    AND  configuracao_entidade.cod_modulo   = 0
                    AND configuracao_entidade.parametro = 'tc_codigo_unidade_gestora'
                WHERE entidade.exercicio = '".Sessao::getExercicio()."'
                AND entidade.cod_entidade = ".$this->getDado('cod_entidade')."
    ";
    return $stSql;
}

}
?>
