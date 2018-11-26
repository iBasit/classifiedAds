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

            return new Response('', Response::HTTP_CREATED); // 200 empty response, we can also sent this entity back as a response
        } else {
            $errors = $this->getErrorsFromForm($form);
            return new JsonResponse([
                'message' => 'There was a validation error',
                'errors' => $errors
            ], Response::HTTP_BAD_REQUEST);
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
                'message' => 'Object not found',
            ], Response::HTTP_NOT_FOUND);
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
                'message' => 'There was a validation error',
                'errors' => $errors
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/ads", name="ads_list", methods={"GET"})
     */
    public function listAdsAction (Request $request, EntityManagerInterface $em)
    {
        $ads = $em->getRepository(Ad::class)->getAll();

        $data = $this->get('jms_serializer')->serialize($ads, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
