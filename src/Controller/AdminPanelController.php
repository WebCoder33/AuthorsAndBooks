<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function admin(Request $request)
    {
        $author = new Author();
        $book = new Book();
        //$book->setName('name')->setIsbn(123)->setPageCount(12)->setYear(2011);
        $author->addBook($book);
        $form = $this->createForm(AuthorType::class, $author);
        //dd($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$author` variable has also been updated
            $author = $form->getData();
            dd($author);
            // ... perform some action, such as saving the author to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($author);
            // $entityManager->flush();

            //return $this->redirectToRoute('task_success');
        }

        return $this->render('admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
            'form' => $form->createView(),
        ]);
    }
}
