<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Component\FlashComponent;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\TableRegistry;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @property \App\Model\Table\CommentsTable $Comments
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->set('articles', $this->Articles->find()->all());
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id);
        $this->set(compact('article'));

        $comments = $this->getTableLocator()->get('Comments')->find();
        $comments->where(['article_id' => $id]);
        $this->set(compact('comments'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);

        $categories = $this->Articles->Categories->find('treeList')->all();
        $this->set(compact('categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
        $this->set('article', $article);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function likeUp($id = null)
    {
        $commentsTable = TableRegistry::getTableLocator()->get('Comments');
        $comment = $commentsTable->get($id);
        $likes = $comment->get('likes');

        $comment->likes = $likes + 1;
        $commentsTable->save($comment);

        $this->Flash->success('Comment has been liked.');

        /*
            $identity = $this->request->getAttribute('authentication')->getIdentity();
            $userId = $identity['id'];
        */

        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function likeDown($id = null)
    {
        $commentsTable = TableRegistry::getTableLocator()->get('Comments');
        $comment = $commentsTable->get($id);
        $likes = $comment->get('likes');

        $comment->likes = $likes - 1;
        $commentsTable->save($comment);

        $this->Flash->success('Comment has been unliked.');

        return $this->redirect($this->referer(['action' => 'index']));
    }
}
