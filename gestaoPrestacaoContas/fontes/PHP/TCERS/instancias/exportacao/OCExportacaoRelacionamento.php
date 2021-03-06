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
 * Página Oculta - Exportação Arquivos de Relacionamento
 * Data de Criação   : 02/01/2005

 * @author Analista: Diego Barbosa Victoria
 * @author Desenvolvedor: Cleisson da Silva Barboza

 * @ignore

 $Id: OCExportacaoRelacionamento.php 59612 2014-09-02 12:00:51Z gelson $

 * Casos de uso: uc-02.08.03
 */

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once CLA_EXPORTADOR;
include_once CAM_GPC_TCERS_NEGOCIO."RExportacaoTCERSArquivosRelacionamento.class.php";

$stAcao = $request->get('stAcao');

$arFiltro = Sessao::read('filtroRelatorio');

$inPeriodo      = $arFiltro['inPeriodo'];
$slTipoArquivo  = $arFiltro['slTipoArquivo'];
$inTmsInicial   = mktime(0,0,0,01,01,Sessao::getExercicio());
$stDataInicial  = date  ('d/m/Y',$inTmsInicial );

# Tratar data inicial e final

if ($slTipoArquivo == 2) {
    //switch bimestre
    switch ($inPeriodo) {
        case 1:
            $inTmsFinal  = mktime(0,0,0,3,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;

        case 2:
            $inTmsFinal  = mktime(0,0,0,5,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;

        case 3:
            $inTmsFinal  = mktime(0,0,0,7,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;

        case 4:
            $inTmsFinal  = mktime(0,0,0,9,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;

        case 5:
            $inTmsFinal  = mktime(0,0,0,11,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;

        case 6:
            $inTmsFinal  = mktime(0,0,0,12,31,Sessao::getExercicio() )       ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal            )       ;
        break;
    }
}

if ($slTipoArquivo == 3) {
    //switch trimestre
    switch ($inPeriodo) {
        case 1:
            $inTmsFinal  = mktime(0,0,0,4,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal );
        break;

        case 2:
            $inTmsFinal  = mktime(0,0,0,7,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal );
        break;

        case 3:
            $inTmsFinal  = mktime(0,0,0,10,01,Sessao::getExercicio() ) - 1   ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal );
        break;

        case 4:
            $inTmsFinal  = mktime(0,0,0,12,31,Sessao::getExercicio() )        ;
            $stDataFinal = date  ('d/m/Y',$inTmsFinal );
        break;
    }
}

    $arFiltro['stDataInicio'] = str_replace('/','',$stDataInicial);
    $arFiltro['stDataFinal'] = str_replace('/','',$stDataFinal);

    $arFiltro = Sessao::write('exp_arFiltro',$arFiltro);

    $stCodEntidade = implode(",",$arFiltro['arEntidadesSelecionadas']);

    //Gerando o Array de RecordSets
    $obRExportacaoTcersArquivosRelacionamento = new RExportacaoTcersArquivosRelacionamento();
    $obRExportacaoTcersArquivosRelacionamento->setArquivos     ($arFiltro["arArquivosSelecionados"]);
    $obRExportacaoTcersArquivosRelacionamento->setExercicio    (Sessao::getExercicio());
    $obRExportacaoTcersArquivosRelacionamento->setDataInicial  ($stDataInicial);
    $obRExportacaoTcersArquivosRelacionamento->setDataFinal    ($stDataFinal);
    $obRExportacaoTcersArquivosRelacionamento->setCodEntidade  ( $stCodEntidade );
    $obRExportacaoTcersArquivosRelacionamento->geraRecordsetAjustes ($arRecordSet);

    if (in_array("CTA_DISP.TXT",$arFiltro["arArquivosSelecionados"])) {

        if ($arRecordSet["CTA_DISP.TXT"]->getNumLinhas() != 0) {

            include_once ( CAM_GPC_TCERS_MAPEAMENTO."TExportacaoTCERSConfiguracao.class.php" );
            include_once( CAM_GF_ORC_NEGOCIO."ROrcamentoConfiguracao.class.php"  );

            $obRConfiguracaoOrcamento = new ROrcamentoConfiguracao;
            $obRConfiguracaoOrcamento->setExercicio( Sessao::getExercicio()    );
            $obRConfiguracaoOrcamento->consultarConfiguracao();

            $obTExportacaoConfiguracao = new TExportacaoTCERSConfiguracao;

            $inCodPrefeitura = $obRConfiguracaoOrcamento->getCodEntidadePrefeitura();
            $inCodCamara     = $obRConfiguracaoOrcamento->getCodEntidadeCamara();
            $inCodRPPS       = $obRConfiguracaoOrcamento->getCodEntidadeRPPS();

            $obTExportacaoConfiguracao->setDado("parametro","orgao_unidade_prefeitura");
            $obTExportacaoConfiguracao->consultar();
            $inCodOUExecutivo = $obTExportacaoConfiguracao->getDado("valor");

            $obTExportacaoConfiguracao->setDado("parametro","orgao_unidade_camara");
            $obTExportacaoConfiguracao->consultar();
            $inCodOULegislativo = $obTExportacaoConfiguracao->getDado("valor");

            $obTExportacaoConfiguracao->setDado("parametro","orgao_unidade_rpps");
            $obTExportacaoConfiguracao->consultar();
            $inCodOURPPS = $obTExportacaoConfiguracao->getDado("valor");

            $obTExportacaoConfiguracao->setDado("parametro","orgao_unidade_outros");
            $obTExportacaoConfiguracao->consultar();
            $inCodOUOutros = $obTExportacaoConfiguracao->getDado("valor");

            $arElementos = $arRecordSet["CTA_DISP.TXT"]->getElementos();

            $inCount = 0;
            foreach ($arElementos as $key => $array) {
                  $arDadosArquivo[$inCount]['cod_estrutural']    = $array['cod_estrutural'];
                  $arDadosArquivo[$inCount]['cod_recurso']       = $array['cod_recurso'];
                  $arDadosArquivo[$inCount]['cod_banco']         = $array['cod_banco'];
                  $arDadosArquivo[$inCount]['cod_agencia']       = $array['cod_agencia'];
                  $arDadosArquivo[$inCount]['conta_corrente']    = $array['conta_corrente'];
                  $arDadosArquivo[$inCount]['tipo_conta']        = $array['tipo_conta'];
                  $arDadosArquivo[$inCount]['cod_classificacao'] = $array['cod_classificacao'];

                  switch ($array['cod_entidade']) {
                    case $inCodPrefeitura   : $arDadosArquivo[$inCount]['orgao_unidade'] = $inCodOUExecutivo; break;
                    case $inCodCamara       : $arDadosArquivo[$inCount]['orgao_unidade'] = $inCodOULegislativo; break;
                    case $inCodRPPS         : $arDadosArquivo[$inCount]['orgao_unidade'] = $inCodOURPPS; break;
                    DEFAULT                 : $arDadosArquivo[$inCount]['orgao_unidade'] = $inCodOUOutros;
                  }
                  $inCount++;
            }
        }
    }

    if (in_array("CTA_OPER.TXT",$arFiltro["arArquivosSelecionados"])) {
        Sessao::write('CTA_OPER.TXT', $arRecordSet["CTA_OPER.TXT"]);
    }

    //Criando o exportador
    $obExportador = new Exportador();

    if (in_array("CTA_DISP.TXT",$arFiltro["arArquivosSelecionados"])) {

        $arRecordSet = new RecordSet;
        $arRecordSet->preenche($arDadosArquivo);

        //Adicionando arquivo CTA_DISP.TXT
        $obExportador->addArquivo("CTA_DISP.TXT");
        $obExportador->roUltimoArquivo->setTipoDocumento("TCE_RS");

        $obExportador->roUltimoArquivo->addBloco($arRecordSet);
        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("cod_estrutural");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(20);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("orgao_unidade");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(04);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("cod_recurso");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(04);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("cod_banco");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(05);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("cod_agencia");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(05);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("conta_corrente");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(20);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("tipo_conta");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(01);

        $obExportador->roUltimoArquivo->roUltimoBloco->addColuna("cod_classificacao");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTipoDado("NUMERICO_ZEROS_ESQ");
        $obExportador->roUltimoArquivo->roUltimoBloco->roUltimaColuna->setTamanhoFixo(01);

    }

    //Adicionando arquivo CTA_OPER.TXT
    if (in_array("CTA_OPER.TXT",$arFiltro["arArquivosSelecionados"])) {

        if (Sessao::read('CTA_OPER.TXT') instanceof RecordSet) {
            $rsCTAOper = Sessao::read('CTA_OPER.TXT');
        }

        $obExportador->addArquivo("CTA_OPER.TXT");
        $obExportador->roUltimoArquivo->setTipoDocumento("TCE_RS");
        $obExportador->roUltimoArquivo->addBloco($rsCTAOper);
    }

    //Definindo o nome do arquivo ZIP caso a opção seja para arquivo zipado
    if ($arFiltro['boTipoExportacao']==2) {
        $obExportador->setNomeArquivoZip('ArquivosRelacionamento.zip');
    }

    //Executando a Exportação
    $obExportador->show();

?>
