<script type="text/javascript">
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
</script>
<?
/**
    * Data de Criação: 10/09/2007

    
    * @author Analista: Gelson W. Gonçalves
    * @author Desenvolvedor: Henrique Boaventura 
    
    * @package URBEM
    * @subpackage 
    
    $Revision: 28470 $
    $Name$
    $Author: luiz $
    $Date: 2008-03-10 16:25:04 -0300 (Seg, 10 Mar 2008) $
    
    * Casos de uso: uc-03.01.06
*/

/*
$Log$
Revision 1.1  2007/10/17 13:42:13  hboaventura
correção dos arquivos


*/
?>
<script>
	function Limpar()
	{
		var grupo = document.getElementById('inCodGrupo');
			
		var tam = grupo.options.length;
        while (tam >= 1) {
            grupo.options[tam] = null;
            tam = tam - 1 ;
        }	
			
		var especie = document.getElementById('inCodEspecie');
		
		var tam = especie.options.length;
        while (tam >= 1) {
            especie.options[tam] = null;
            tam = tam - 1 ;
        }	
		
		limpaFormulario();
	}
</script>
