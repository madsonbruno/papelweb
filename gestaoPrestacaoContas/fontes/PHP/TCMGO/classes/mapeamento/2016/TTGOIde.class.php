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
    * Extensão da Classe de mapeamento
    * Data de Criação: 30/01/2007

    * @author Analista: Diego Barbosa Victoria
    * @author Desenvolvedor: Cleisson Barboza

    * @package URBEM
    * @subpackage Mapeamento

    $Id: TTGOIde.class.php 65740 2016-06-13 20:22:33Z franver $

    * Casos de uso: uc-06.04.00
*/
include_once CLA_PERSISTENTE;

class TTGOide extends Persistente
{
    /**
        * Método Construtor
        * @access Private
    */
    public function __construct()
    {
        parent::Persistente();
        $this->setDado('exercicio', Sessao::getExercicio() );
    }

    //Mapeamento do case pode ser encontrado no documento de tabelas auxiliares do tribunal
    public function montaRecuperaTodos()
    {
        $inMes = explode('/',$this->getDado('dtFim'));
        $inMes = $inMes[1];
        $stSql  = "
            SELECT  '10' AS tipo_registro
                 ,  valor AS codigo_entidade
                 ,  (   SELECT  valor
                          FROM  administracao.configuracao_entidade AS ent
                         WHERE  ent.cod_entidade = configuracao_entidade.cod_entidade
                           AND  ent.exercicio = configuracao_entidade.exercicio
                           AND  ent.parametro = 'tc_codigo_tipo_balancete'";
        if ($this->getDado('inCodModulo')) {
            $stSql .= " AND ent.cod_modulo = ".$this->getDado('inCodModulo');
        }
    
        $stSql .= "
                    ) AS tipo_balancete
                 ,  exercicio AS ano_referencia
                 ,  ".$inMes." AS mes_referencia
                 ,  '0' AS balancete_complementar
                 ,  to_char(NOW(),'ddmmyyyy') AS data_geracao
                 ,  '1' AS numero_registro
              FROM  administracao.configuracao_entidade
             WHERE  cod_entidade IN ( ".$this->getDado('stEntidades')." )
               AND  exercicio = '".$this->getDado('exercicio')."'
               AND  parametro = 'tc_codigo_unidade_gestora'

        ";

        return $stSql;
    }
}