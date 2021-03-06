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
    * Página de Formulario que filtra de Relatórios de Receita
    * Data de Criação: 12/11/2008

    * @author Analista: Heleno Menezes dos Santos
    * @author Desenvolvedor: Janilson Mendes P. da Silva

    * @package URBEM
    * @subpackage

    * Casos de uso: UC-02.09
*/

require_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
require_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
require_once(CAM_GF_PPA_COMPONENTES."ITextBoxSelectPPA.class.php");
require_once(CAM_GF_PPA_COMPONENTES."IPopUpContaReceita.class.php");
require_once(CAM_GF_PPA_COMPONENTES."IPopUpRecurso.class.php");
include_once(CAM_GF_LDO_COMPONENTES."IPopUpRubrica.class.php");
require_once(CAM_GA_ADM_COMPONENTES."IMontaAssinaturas.class.php");
require_once(CAM_GF_PPA_NEGOCIO."/RPPAHomologarPPA.class.php");
require_once(CAM_GRH_PES_COMPONENTES . 'IFiltroContrato.class.php');
require_once '../../../../../../gestaoFinanceira/fontes/PHP/ppa/classes/visao/VPPAHomologarPPA.class.php';

//Instanciando a Classe de Controle e de Visao de Homologar para Trazer o PPA vigente pelo Exercício
$obController = new RPPAHomologarPPA;
$obVisao = new VPPAHomologarPPA($obController);

$rsRecordSet = $obVisao->pesquisaPPANorma($stFiltro);

$inCount = count($rsRecordSet->arElementos);
$inAnoExercicio = Sessao::getExercicio();

for ($i = 0; $i < $inCount; $i++) {
    $arCampos = $rsRecordSet->arElementos[$i];

    if ($arCampos['ano_inicio'] <= $inAnoExercicio && $inAnoExercicio <= $arCampos['ano_final']) {
        $inCodPPA = $arCampos['cod_ppa'];
    }
}

### Entidades Cadastradas no Sistema ###
$stEntidades = $obVisao->montarEntidades();

//Define o nome dos arquivos PHP
$stPrograma = "RelatorioReceita";
$pgOcul = "OC".$stPrograma.".php";
$pgProc = "PR".$stPrograma.".php";
$pgJs = "JS".$stPrograma.".php";

$stAcao = $request->get('stAcao');

### Campos Hidden ###
$obHdnAcao = new Hidden();
$obHdnAcao->setName("stAcao");
$obHdnAcao->setValue("encaminhaRelatorioReceita");

$obHdnCtrl = new Hidden();
$obHdnCtrl->setName("stCtrl");
$obHdnCtrl->setValue("encaminhaRelatorioReceita");

$obHdnPPAVigente = new Hidden();
$obHdnPPAVigente->setName("inCodPPAVigente");
$obHdnPPAVigente->setValue($inCodPPA);

$obHdnEntidade = new Hidden;
$obHdnEntidade->setName("inCodEntidade");
$obHdnEntidade->setId("inCodEntidade");
$obHdnEntidade->setValue($stEntidades);

$obHdnAssinatura = new Hidden;
$obHdnAssinatura->setName("boAssinaturas");
$obHdnAssinatura->setId("boAssinaturas");
$obHdnAssinatura->setValue('n');

### Form ###
$obForm = new Form();
$obForm->setAction($pgProc);
$obForm->setTarget("oculto");

### ITextBoxSelectPPA ###
$obITextBoxSelectPPA = new ITextBoxSelectPPA();
$obITextBoxSelectPPA->setCodPPA($inCodPPA);
$obITextBoxSelectPPA->setNull(null);

### Informar Código Receita Inicial ###
$obIPopUpReceitaIni = new IPopUpRubrica();
$obIPopUpReceitaIni->setRotulo("Receita(s)");
$obIPopUpReceitaIni->setId('stDescricaoCodReceitaIni');
$obIPopUpReceitaIni->obCampoCod->setName('inCodReceitaIni');
$obIPopUpReceitaIni->obCampoCod->setId('inCodReceitaIni');
$obIPopUpReceitaIni->obHiddenCodConta->setName("inCodContaIni");
$obIPopUpReceitaIni->obHiddenCodConta->setId("inCodContaIni");
$obIPopUpReceitaIni->setDedutora(false);
$obIPopUpReceitaIni->setNull(true);

### Label Receita ###
$obLabelReceita = new Label();
$obLabelReceita->setValue('até');

### Informar Código Receita Final ###
$obIPopUpReceitaFim = new IPopUpRubrica();
$obIPopUpReceitaFim->setRotulo('Receita(s)');
$obIPopUpReceitaFim->setRotulo('Receita(s)');
$obIPopUpReceitaFim->setId('stDescricaoCodReceitaFim');
$obIPopUpReceitaFim->obCampoCod->setName('inCodReceitaFim');
$obIPopUpReceitaFim->obCampoCod->setId('inCodReceitaFim');
$obIPopUpReceitaFim->obHiddenCodConta->setName("inCodContaFim");
$obIPopUpReceitaFim->obHiddenCodConta->setId("inCodContaFim");
$obIPopUpReceitaFim->setDedutora(false);
$obIPopUpReceitaFim->setNull(true);

### Informar o Código Recurso ###
$obIPopUpRecurso = new IPopUpRecurso($obForm);
$obIPopUpRecurso->obInnerRecurso->obCampoCod->setId('inCodRecurso');
$obIPopUpRecurso->setNull(true);

### Ordenar ###
$obSelectOrdem = new Select();
$obSelectOrdem->setName('inOrdem');
$obSelectOrdem->setRotulo('Ordenar por');
$obSelectOrdem->setId('inOrdem');
$obSelectOrdem->addOption('1', 'Código');
$obSelectOrdem->addOption('2', 'Descrição');

### Instanciação do objeto Lista de Assinaturas ###
$obMontaAssinaturas = new IMontaAssinaturas();

$obFormulario = new Formulario();
$obFormulario->addForm($obForm);
$obFormulario->addHidden($obHdnAcao);
$obFormulario->addHidden($obHdnCtrl);
$obFormulario->addHidden($obHdnPPAVigente);
$obFormulario->addHidden($obHdnEntidade);
$obFormulario->addHidden($obHdnAssinatura);
$obFormulario->addTitulo('Filtro Receitas');
$obFormulario->addComponente($obITextBoxSelectPPA);
$obIPopUpReceitaIni->geraFormulario($obFormulario);
$obIPopUpReceitaFim->geraFormulario($obFormulario);
$obFormulario->addComponente($obIPopUpRecurso);
$obFormulario->addComponente($obSelectOrdem);
$obMontaAssinaturas->geraFormulario($obFormulario); // Injeção de código no formulário

$obBtnOk = new Ok;

$obBtnLimpar = new Button;
$obBtnLimpar->setName('Limpar');
$obBtnLimpar->setValue('Limpar');
$obBtnLimpar->obEvento->setOnClick('limpaFormulario()');

$obFormulario->defineBarra(array($obBtnOk , $obBtnLimpar));

$obFormulario->show();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
