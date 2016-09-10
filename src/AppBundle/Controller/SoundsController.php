<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sound;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SoundsController extends Controller
{
	/**
	* @Route("/sounds", name="sounds")
	*/
	public function indexAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Sound');
		$sounds = $repository->findAll();

		return $this->render('sounds/index.html.twig', array(
			"sounds" => $sounds,
			"user" => $this->getUser()
		));
	}

	/**
	* @Route("/sounds/{id}/show", name="soundsShow")
	*/
	public function showAction($id)
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Sound');
		$sound = $repository->find($id);
		if (!$sound) throw $this->createNotFoundException('No sound found for id '.$id);
		
		$comments = $sound->getComments();
		
		foreach ($comments as $key => $comment) {
			if((!$comment->getVisibility() ) and (!$comment->editableBy($this->getUser()))) {
				unset ($comments[$key]);
			}		
		}
		

		return $this->render('sounds/show.html.twig', array(
			"sound" => $sound,
			"comments" => $comments,
			"user" => $this->getUser()
		));
	}

	/**
	* @Route("/sounds/add", name="soundsAdd")
	*/
	public function addAction()
	{
		$user = $this->getUser();
		$speakers = $this->getDoctrine()->getRepository('AppBundle:Speaker')->findByUser($user);
		$languages = $this->getDoctrine()->getRepository('AppBundle:Language')->findAll();

		return $this->render('sounds/add.html.twig', array(
			"user" => $user,
			"speakers" => $speakers,
			"languages" => $languages
		));
	}

	/**
	* @Route("/api/sounds", name="soundsApi")
	*/
	public function postAction(Request $request)
	{
		try {
			$em = $this->getDoctrine();

			$user = $em->getRepository('AppBundle:User')->find($request->request->get("user"));
			if (!$user) throw new Exception('No user found');

			$speaker = $em->getRepository('AppBundle:Speaker')->find($request->request->get("speaker"));
			if (!$speaker) throw new Exception('No speaker found');

			$language = $em->getRepository('AppBundle:Language')->find($request->request->get("lang"));
			if (!$language) throw new Exception('No language found');
			
			$filename = dechex(crc32(rand(0, 32000))).".wav";
			$file = $request->files->get("sound");
			if ($file == null) throw new Exception("no file sent");
			if ($file->getMimeType() != "audio/x-wav") throw new Exception("this is not a wave file");
			$file->move($this->container->getParameter('audio_path'), $filename);

			$sound = new Sound();
			$sound->setText($request->request->get("text"));
			
			$description = $request->request->get("description");
			if ($description) $sound->setDescription($description);

			$sound->setDescription($request->request->get("text"));
			$sound->setUser($user);
			$sound->setFilename($filename);
			$sound->setSpeaker($speaker);
			$sound->setLang($language);
			$em = $this->getDoctrine()->getManager();
			$em->persist($sound);
			$em->flush();
		}
		catch (Exception $e) {
			return new Response(json_encode(false));
		}
		return new Response(json_encode(true));
	}

	/**
	* @Route("/sounds/{id}/update", name="soundsUpdate")
	*/
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$sound = $em->getRepository('AppBundle:Sound')->find($id);
		if (!$sound) throw $this->createNotFoundException('No sound found for id '.$id);
		if (!$sound->getUser()->editableBy($this->getUser())) throw $this->createAccessDeniedException('Forbidden');

		$form = $this->createFormBuilder($sound)
			->add('lang', EntityType::class, array('class' => 'AppBundle:Language', 'choice_label' => 'title'))
			->add('text', TextType::class)
			->add('description', TextareaType::class)
			->add('speaker', EntityType::class, array('class' => 'AppBundle:Speaker', 'choice_label' => 'name', "choices" => $sound->getUser()->getSpeakers()))
			->add('save', SubmitType::class, array('label' => 'Ok'))
			->getForm();

		//Enregistrement 
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($sound);
			$em->flush();
			if ($request->get("redirect")) return $this->redirect($request->get("redirect"));
			return $this->redirectToRoute("soundsShow", array("id" => $id));
		}

		$token = $this->get('security.token_storage')->getToken();
		return $this->render('sounds/update.html.twig', array(
			"sound" => $sound,
			"form" => $form->createView(),
			"token" => $token
		));
	}


	/**
	* @Route("/sounds/{id}/delete", name="soundsDelete")
	*/
	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository('AppBundle:Sound');
		$sound = $repository->find($id);

		if (!$sound) {
			throw $this->createNotFoundException('No message found for id '.$id);
		}
		if (!$sound->getUser()->editableBy($this->getUser())) throw $this->createAccessDeniedException('Forbidden');

		$form = $this->createFormBuilder($sound)
			->add('save', SubmitType::class, array('label' => 'Confirmer'))
			->getForm();

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$user_id = $sound->getUser()->getId();
			$em->remove($sound);
			$em->flush();
			if ($request->get("redirect")) return $this->redirect($request->get("redirect"));
			return $this->redirectToRoute('usersSounds', array("id" => $user_id));
		}

		$token = $this->get('security.token_storage')->getToken();
		return $this->render('sounds/delete.html.twig', array(
			"sound" => $sound,
			"form" => $form->createView(),
			"token" => $token
		));
	}
}
