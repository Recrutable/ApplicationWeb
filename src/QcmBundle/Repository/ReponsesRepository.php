<?php

namespace QcmBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;

/**
 * ReponsesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReponsesRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $idQuestionnaire
     * @param $idUser
     * @return array
     */
    public function getEtatQuestionnaire($idQuestionnaire,$idUser)
    {
        $em = $this->getEntityManager();

        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(REP.id) as nb_reponses')
            ->from('QcmBundle:Reponses', 'REP')
            ->innerJoin('REP.question', 'QU')
            ->leftJoin('QU.idQuestionnaire', 'REF')
            ->leftJoin('REP.user','USR')
            ->where("USR.id = {$idUser}","REF.id = {$idQuestionnaire}")
            ->getQuery();

        $reponse = $queryBuilder->getResult();
        if((bool) $reponse) {
            $nombreReponse = $reponse[0]['nb_reponses'];
        } else {
            $nombreReponse = 0;
        }

        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(QU.id) as nb_question')
            ->from('QcmBundle:Questions', 'QU')
            ->innerJoin('QU.idQuestionnaire', 'REF')
            ->where("REF.id = {$idQuestionnaire}")
            ->getQuery();

        $reponse = $queryBuilder->getResult();
        if((bool) $reponse) {
            $nombreQuestion = $reponse[0]['nb_question'];
        } else {
            $nombreQuestion = 0;
        }

        return array(
            'nb_reponse'=>$nombreReponse,
            'nb_question'=>$nombreQuestion
        );
    }

    public function getPourcentage($questionnaireId,$UserId)
    {

        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('SUM(REP.topBonneReponse)/COUNT(REP.id) * 100 as pct_reponse')
            ->from('QcmBundle:Reponses', 'REP')
            ->innerJoin('REP.question', 'QU')
            ->leftJoin('QU.idQuestionnaire', 'REF')
            ->leftJoin('REP.user','USR')
            ->where("USR.id = {$UserId}","REF.id = {$questionnaireId}")
            ->getQuery();

        $reponse = $queryBuilder->getResult();
        if((bool) $reponse) {
            $pourcentageReponse = $reponse[0]['pct_reponse'];
        } else {
            $pourcentageReponse = 'NR';
        }
        return $pourcentageReponse;

    }
}
