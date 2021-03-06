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
    * @author Analista: Gelson W. Gonçalves
    * @author Desenvolvedor: Evandro Melos
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once ( CLA_PERSISTENTE );

class TPatrimonioGrupoPlanoDepreciacao extends Persistente
{
/**
    * Método Construtor
    * @access Private
*/
function __construct()
{
    parent::__construct();
    $this->setTabela('patrimonio.grupo_plano_depreciacao');
    $this->setCampoCod('cod_grupo');
    $this->setComplementoChave('cod_natureza,exercicio,cod_plano');
    $this->AddCampo('cod_grupo','integer',true,'',true,false);
    $this->AddCampo('cod_natureza','integer',true,'',true,"TPatrimonioNatureza");
    $this->AddCampo('exercicio','varchar',true,'4',true,false);
    $this->AddCampo('cod_plano','integer',true,'',true,false);

}

public function recuperaPlanoDepreciacao(&$rsRecordSet, $stFiltro = "", $stOrdem = "", $boTransacao = "")
{
    $obErro      = new Erro;
    $obConexao   = new Conexao;
    $rsRecordSet = new RecordSet;
    $stSql = $this->montaRecuperaPlanoDepreciacao().$stFiltro.$stOrdem;
    $this->stDebug = $stSql;
    $obErro = $obConexao->executaSQL( $rsRecordSet, $stSql, $boTransacao );
    
    return $obErro;
}

public function montaRecuperaPlanoDepreciacao()
{
    $stSql = "SELECT grupo_plano_depreciacao.cod_plano AS cod_plano,
                           plano_conta.nom_conta,
                           grupo_plano_depreciacao.cod_natureza,
                           grupo_plano_depreciacao.cod_grupo,
                           grupo_plano_depreciacao.exercicio
                      FROM patrimonio.grupo_plano_depreciacao
                 
                 LEFT JOIN contabilidade.plano_analitica
                        ON plano_analitica.cod_plano = grupo_plano_depreciacao.cod_plano
                       AND plano_analitica.exercicio = grupo_plano_depreciacao.exercicio
                 
                 LEFT JOIN contabilidade.plano_conta
                        ON plano_conta.cod_conta = plano_analitica.cod_conta
                       AND plano_conta.exercicio = plano_analitica.exercicio \n";
    
    return $stSql;
    
}

}

?>