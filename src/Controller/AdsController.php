<?php


namespace App\Controller;


use App\Entity\Ad;
use App\Entity\User;
use App\Form\Type\AdsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/v1")
 */
class AdsController extends ApiBaseController
{
    /**
     * @Route("/ads/create", name="ads_create", methods={"POST"})
     */
    public function createAdsAction (Request $request, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        $ad = new Ad();

        $form = $this->createAPIForm(AdsType::class, $ad, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ad->setUser($user);
            $em->persist($ad);
            $em->flush();

            return new Response(); // 200 empty response, we can also sent this entity back as a response
        } else {
            $errors = $this->getErrorsFromForm($form);
            return new JsonResponse([
                'title' => 'There was a validation error',
                'errors' => $errors
            ], 400);
        }
    }

    /**
     * @Route("/ads/{id}", name="ads_update", methods={"PUT"})
     */
    public function updateAdsAction (Request $request, $id, EntityManagerInterface $em)
    {
        $ad = $em->getRepository(Ad::class)->find($id);

        if (!$ad) {
            return new JsonResponse([
                'title' => 'Object not found',
                'errors' => []
            ], 404);
        }

        $form = $this->createAPIForm(AdsType::class, $ad, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ad);
            $em->flush();

            return new Response(); // 200 empty response, we can also sent this entity back as a response
        } else {
            $errors = $this->getErrorsFromForm($form);
            return new JsonResponse([
                'title' => 'There was a validation error',
                'errors' => $errors
            ], 400);
        }
    }

    /**
     * @Route("/ads", name="ads_list", methods={"GET"})
     */
    public function listAdsAction (Request $request, EntityManagerInterface $em)
    {
        $ads = $em->getRepository(Ad::class)->getAll();

        $data = $this->get('jms_serializer')->serialize($ads, 'json');

        return new JsonResponse($data, 200, [], true);
    }

    protected function getUser()
    {
        return $this->getDoctrine()->getRepository(User::class)->find(1);
    }
}
