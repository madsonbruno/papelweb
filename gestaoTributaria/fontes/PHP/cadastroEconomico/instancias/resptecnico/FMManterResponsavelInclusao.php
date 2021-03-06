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
    * Classe de regra de negócio para Responsavel Tecnico
    * Data de Criação: 14/04/2005

    * @author Analista: Fabio Bertoldi Rodrigues
    * @author Desenvolvedor: Lucas Teixeira Stephanou
    * @author Desenvolvedor: Lizandro Kirst da Silva
    * @author Desenvolvedor: Fernando Piccini Cercato
    * @ignore

    * $Id: FMManterResponsavelInclusao.php 63839 2015-10-22 18:08:07Z franver $

    *Casos de uso: uc-05.02.04
*/

/*
$Log$
Revision 1.7  2006/09/15 14:33:35  fabio
correção do cabeçalho,
adicionado trecho de log do CVS

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GA_CSE_NEGOCIO."RProfissao.class.php"         );
include_once ( CAM_GA_CSE_NEGOCIO."RConselho.class.php"          );
include_once ( CAM_GT_CEM_NEGOCIO."RCEMConfiguracao.class.php"   );
include_once ( CAM_GA_ADM_NEGOCIO."RAdministracaoUF.class.php"                );

//Define o nome dos arquivos PHP
$stPrograma    = "ManterResponsavel";
$pgFilt        = "FL".$stPrograma.".php";
$pgList        = "LS".$stPrograma.".php";
$pgForm        = "FM".$stPrograma.".php";
$pgProc        = "PR".$stPrograma.".php";
$pgOcul        = "OC".$stPrograma.".php";
$pgJs          = "JS".$stPrograma.".js";
include_once( $pgJs );

$stAcao = $request->get('stAcao');
if ( empty( $stAcao ) ) {
    $stAcao = "incluir";
}

// INSTANCIA REGRAS UTILIZADAS

$obRConselho    = new RConselho     ;
$obRProfissao   = new RProfissao    ;
$obRUF          = new RUF           ;

$rsProfissoesDisponiveis = $rsProfissoesSelecionadas = new RecordSet;
$obRProfissao->listarProfissao($rsProfissoes);
$arListaProfissoes = array();
$numero_profissao = 0;
while ( !$rsProfissoes->eof() ) {
    if ($rsProfissoes->getCampo("cod_profissao") != 0) {
        $arListaProfissoes[$numero_profissao]["cod_profissao"] = $rsProfissoes->getCampo("cod_profissao");
        $arListaProfissoes[$numero_profissao]["nom_profissao"] = $rsProfissoes->getCampo("nom_profissao");
        $arListaProfissoes[$numero_profissao]["cod_conselho"] = $rsProfissoes->getCampo("cod_conselho");
        $numero_profissao++;
    }

    $rsProfissoes->proximo();
}

$rsProfissoes = new RecordSet();
$rsProfissoes->preenche($arListaProfissoes);
$rsProfissoesDisponiveis->preenche($arListaProfissoes);
$obRUF->listarUF($rsUF);

// HIDDENS
$obHdnAcao  = new Hidden;
$obHdnAcao->setName     ( "stAcao" );
$obHdnAcao->setId       ( "stAcao" );
$obHdnAcao->setValue    ( $stAcao  );

$obHdnCtrl  = new Hidden;
$obHdnCtrl->setName ( "stCtrl" );
$obHdnCtrl->setId   ( "stCtrl" );

// HIDDENS E COMPONENTES LABEL PARA ALTERAÇÃO
$obBoTipoResponsavel = new Hidden;
$obBoTipoResponsavel->setName  ( "boTipoResponsavel" );
$obBoTipoResponsavel->setValue ( $_REQUEST["boTipoResponsavel"] );

// pega nome da profissao
$obRProfissao->setCodigoProfissao( $_REQUEST["inCodigoProfissao"] );
$obRProfissao->consultarProfissao();

$obLblProfissao = new Label;
$obLblProfissao->setRotulo  ( "Profissão"                       );
$obLblProfissao->setName    ( "stProfissao"                     );
$obLblProfissao->setValue   ( $obRProfissao->getNomeProfissao() );

$obHdnProfissao = new Hidden;
$obHdnProfissao->setName    ( "inCodigoProfissao"                   );
$obHdnProfissao->setValue   ( $obRProfissao->getCodigoProfissao()   );

$obLblConselho = new Label;
$obLblConselho->setRotulo  ( "Conselho de Classe"                           );
$obLblConselho->setName    ( "stConselho"                                   );
$obLblConselho->setValue   ( $obRProfissao->obRConselho->getNomeConselho()  );

$obLblCGM = new Label;
$obLblCGM->setRotulo  ( "Profissional"                      );
$obLblCGM->setName    ( "stProfissional"                    );
$obLblCGM->setValue   ( $_REQUEST["inNumCGM"]               );

$obHdnCGM = new Hidden;
$obHdnCGM->setName    ( "inNumCGM"                          );
$obHdnCGM->setValue   ( $_REQUEST["inNumCGM"]               );

$obLblNomCGM = new Label;
$obLblNomCGM->setName    ( "stProfissional"                    );
$obLblNomCGM->setValue   ( $_REQUEST["stNomCGM"]               );

$obHdnNomeRegistro = new Hidden;
$obHdnNomeRegistro->setName    ( "stNomRegistro"                     );
$obHdnNomeRegistro->setValue   ( $_REQUEST["stNomRegistro"]          );

// COMPONENTES
$obTxtProfissao = new TextBox;
$obTxtProfissao->setRotulo        ( "Profissão"                         );
$obTxtProfissao->setTitle         ( "Profissão do Respónsavel Técnico"  );
$obTxtProfissao->setName          ( "inCodigoProfissao"                 );
$obTxtProfissao->setId            ( "inCodigoProfissao"                 );
$obTxtProfissao->setValue         ( $_REQUEST["inCodigoProfissao"]      );
$obTxtProfissao->setSize          ( 8                                   );
$obTxtProfissao->setMaxLength     ( 8                                   );
$obTxtProfissao->setNull          ( false                               );
$obTxtProfissao->setInteiro       ( true                                );
$obTxtProfissao->obEvento->setOnChange("montaAtributosProfissao();"     );

$obCmbProfissao = new Select;
$obCmbProfissao->setName          ( "cmbProfissao"                      );
$obCmbProfissao->setValue         ( $_REQUEST["inCodigoProfissao"]      );
$obCmbProfissao->addOption        ( "", "Selecione"                     );
$obCmbProfissao->setCampoId       ( "cod_profissao"                     );
$obCmbProfissao->setCampoDesc     ( "nom_profissao"                     );
$obCmbProfissao->preencheCombo    ( $rsProfissoes                       );
$obCmbProfissao->setNull          ( false                               );
$obCmbProfissao->setStyle         ( "width: 220px"                      );
$obCmbProfissao->obEvento->setOnChange("montaAtributosProfissao();"     );

$obLblConselhoClasse = new Label;
$obLblConselhoClasse->setName   ( "stNomeConselhoClasse"    );
$obLblConselhoClasse->setId     ( "stNomeConselhoClasse"    );
$obLblConselhoClasse->setRotulo ( "Conselho de Classe"      );
$obLblConselhoClasse->setTitle  ( "Conselho de Classe"      );

$obBscCGM = new BuscaInner;
$obBscCGM->setRotulo    ( "CGM"                             );
$obBscCGM->setTitle     ( "Busca profissional no CGM"       );
$obBscCGM->setId        ( "inNomCGM"                        );
$obBscCGM->setNull      ( false                             );
$obBscCGM->obCampoCod->setName  ( "inNumCGM"    );
$obBscCGM->obCampoCod->setValue ( $_REQUEST["inNumCGM"]     );
if ($_REQUEST["boTipoResponsavel"] == "profissional") {
    $obBscCGM->obCampoCod->obEvento->setOnChange("buscaValor('buscaCGMPF');");
    $tipo_busca = 'fisica';
} else {
    $obBscCGM->obCampoCod->obEvento->setOnChange("buscaValor('buscaCGMPJ');");
    $tipo_busca = 'juridica';
}

$obBscCGM->setFuncaoBusca( "abrePopUp('".CAM_GA_CGM_POPUPS."cgm/FLProcurarCgm.php','frm','inNumCGM','inNomCGM','".$tipo_busca."','".Sessao::getId()."','800','550');" );

$obTxtNomeRegistro = new TextBox;
$obTxtNomeRegistro->setRotulo        ( "<span id='rotRegistro'>Registro</span>" );
$obTxtNomeRegistro->setTitle         ( "Numero do registro no conselho de classe " );
$obTxtNomeRegistro->setName          ( "stRegistro"         );
$obTxtNomeRegistro->setId            ( "stRegistro"         );
$obTxtNomeRegistro->setSize          ( 10                   );
$obTxtNomeRegistro->setMaxLength     ( 10                   );
$obTxtNomeRegistro->setValue         ( $_REQUEST['stRegistro'] );
$obTxtNomeRegistro->setNull          ( false                );

$obTxtUf = new TextBox;
$obTxtUf->setRotulo        ( "UF"                               );
$obTxtUf->setTitle         ( "Estado Correspondente ao conselho de classe"  );
$obTxtUf->setName          ( "inCodigoUf"                       );
$obTxtUf->setValue         ( $_REQUEST["stUF"]                  );
$obTxtUf->setSize          ( 8                                  );
$obTxtUf->setMaxLength     ( 2                                  );
$obTxtUf->setNull          ( false                              );
$obTxtUf->setInteiro       ( true                               );
$obTxtUf->obEvento->setOnChange("montaAtributosUf();"           );

$obCmbUf = new Select;
$obCmbUf->setName          ( "cmbUf"                    );
$obCmbUf->addOption        ( "", "Selecione"            );
$obCmbUf->setValue         ( $_REQUEST['stUF']          );
$obCmbUf->setCampoId       ( "cod_uf"                   );
$obCmbUf->setCampoDesc     ( "nom_uf"                   );
$obCmbUf->preencheCombo    ( $rsUF                      );
$obCmbUf->setNull          ( false                      );
$obCmbUf->setStyle         ( "width: 220px"             );
$obCmbUf->obEvento->setOnChange("montaAtributosUf();"   );

$obBtnIncluirResponsavel = new Button;
$obBtnIncluirResponsavel->setName              ( "btnIncluirResponsavel" );
$obBtnIncluirResponsavel->setValue             ( "Incluir" );
$obBtnIncluirResponsavel->setTipo              ( "button" );
$obBtnIncluirResponsavel->obEvento->setOnClick ( "incluirResponsavel();" );
$obBtnIncluirResponsavel->setDisabled          ( false );

$obBtnLimparResponsavel = new Button;
$obBtnLimparResponsavel->setName               ( "btnLimparResponsavel" );
$obBtnLimparResponsavel->setValue              ( "Limpar" );
$obBtnLimparResponsavel->setTipo               ( "button" );
$obBtnLimparResponsavel->obEvento->setOnClick  ( "buscaValor('limparResponsavel');" );
$obBtnLimparResponsavel->setDisabled           ( false );

$botoesSpanResponsavel = array ( $obBtnIncluirResponsavel, $obBtnLimparResponsavel );

$obSpnListaResponsavel = new Span;
$obSpnListaResponsavel->setID("spnListaResponsavel");

$obHdnCodProf = new Hidden;
$obHdnCodProf->setName    ( "inCodProfissao" );
$obHdnCodProf->setValue   ( $_REQUEST["inCodProfissao"] );

$obHdnAtividadesInscricao = new Hidden;
$obHdnAtividadesInscricao->setName  ( "stAtividades" );
$obHdnAtividadesInscricao->setValue ( $_REQUEST["stAtividades"] );

$obBscResponsavel = new BuscaInner;
$obBscResponsavel->setRotulo    ( "*Responsável" );
$obBscResponsavel->setTitle     ( "Busca Empresa Responsável" );
$obBscResponsavel->setId        ( "inNomResponsavel" );
$obBscResponsavel->setNull      ( true );
$obBscResponsavel->obCampoCod->setName  ( "inNumResponsavelCGM" );
$obBscResponsavel->obCampoCod->setValue ( $_REQUEST["inNumResponsavelCGM"] );
$obBscResponsavel->obCampoCod->obEvento->setOnChange("buscaValor('buscaResponsavelCGM');");
$obBscResponsavel->setFuncaoBusca( " abrePopUp('".CAM_GT_CEM_POPUPS."responsaveltecnico/FLProcurarResponsavel.php','frm','inNumResponsavelCGM&inCodProfissao=inCodProfissao','inNomResponsavel','','".Sessao::getId()."','800','550');" );

//definicao dos combos de atributos
$obCmbMultiploProfissao = new SelectMultiplo();
$obCmbMultiploProfissao->setName ( "inCodAtributoSel" );
$obCmbMultiploProfissao->setRotulo ( "Profissões" );
$obCmbMultiploProfissao->setNull ( false );
$obCmbMultiploProfissao->setTitle ( "Profissões do responsavel tecnico" );

// lista de atributos disponiveis
$obCmbMultiploProfissao->SetNomeLista1 ( "inCodAtributoDisponiveis" );
$obCmbMultiploProfissao->setCampoId1 ( "cod_profissao" );
$obCmbMultiploProfissao->setCampoDesc1 ( "nom_profissao" );
$obCmbMultiploProfissao->SetRecord1 ( $rsProfissoesDisponiveis );
$obCmbMultiploProfissao->setStyle1 ( "width: 300px" );

// lista de atributos selecionados
$obCmbMultiploProfissao->SetNomeLista2 ( "inCodProfissoesSelecionadas" );
$obCmbMultiploProfissao->setCampoId2   ( "cod_profissao" );
$obCmbMultiploProfissao->setCampoDesc2 ( "nom_profissao" );
$obCmbMultiploProfissao->SetRecord2    ( $rsProfissoesSelecionadas );
$obCmbMultiploProfissao->setStyle2     ( "width: 300px" );

//DEFINICAO DO FORM
$obForm = new Form;
$obForm->setAction( $pgProc  );
$obForm->setTarget( "oculto" );

//DEFINICAO DO FORMULARIO
$obFormulario = new Formulario;
$obFormulario->addForm ( $obForm );
$obFormulario->setAjuda ( "UC-05.02.04" );

$obFormulario->addHidden ( $obHdnCtrl );
$obFormulario->addHidden ( $obHdnAcao );
$obFormulario->addHidden ( $obBoTipoResponsavel );
$obFormulario->addHidden ( $obHdnAtividadesInscricao );

if ($_REQUEST["boTipoResponsavel"] == "profissional") {
    $obFormulario->addTitulo ( "Dados para Responsável Técnico" );
    $obFormulario->addComponenteComposto ( $obTxtProfissao, $obCmbProfissao );
    $obFormulario->addComponente ( $obLblConselhoClasse );
    $obFormulario->addComponente ( $obBscCGM );
    $obFormulario->addComponente ( $obTxtNomeRegistro );
    $obFormulario->addComponenteComposto ( $obTxtUf,$obCmbUf );
    $obFormulario->setFormFocus ( $obTxtProfissao->getid() );
} else {
    $obFormulario->addHidden ( $obHdnCodProf );
    $obFormulario->addTitulo ( "Dados para Empresa Responsável" );
    $obFormulario->addComponente ( $obBscCGM );

    $obFormulario->addTitulo ( "Responsável Técnico"  );
    $obFormulario->addComponente ( $obCmbMultiploProfissao );
    $obFormulario->addComponente ( $obBscResponsavel );
    $obFormulario->defineBarra ( $botoesSpanResponsavel,'left','' );
    $obFormulario->addSpan ( $obSpnListaResponsavel );
}

$obFormulario->OK();
$obFormulario->show();
if ($_REQUEST["boTipoResponsavel"] == "empresa") {
    sistemaLegado::executaFrameOculto("document.frm.inNumCGM.focus();");
}

Sessao::write( "responsaveis", array() );
?>
