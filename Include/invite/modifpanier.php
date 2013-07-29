<?php
session_start();

function addpanier($id,$nom,$qte,$prix)
{
	if(isset($_SESSION['caddie']))
	{
		if(isset($_SESSION['caddie'][$id]))//article deja présent
		{
			$_SESSION['caddieTot'] -= $_SESSION['caddie'][$id]['prix']*$_SESSION['caddie'][$id]['qte'];
			$_SESSION['caddie'][$id]['qte'] = $qte;
		}
		else//article nouveau
		{
			$article = array('nom'=>$nom,'prix'=>$prix,'qte'=>$qte,'id'=>$id);
			$_SESSION['caddie'][$id] = $article;
		}
		$_SESSION['caddieTot'] += $_SESSION['caddie'][$id]['prix']*$_SESSION['caddie'][$id]['qte'];
	}
	else
	{
		$article = array('nom'=>$nom,'prix'=>$prix,'qte'=>$qte,'id'=>$id);
		$_SESSION['caddie'][$id] = $article;
		$_SESSION['caddieTot'] = $_SESSION['caddie'][$id]['prix']*$_SESSION['caddie'][$id]['qte'];
	}
}

function deletepanier($id)
{
	if(isset($_SESSION['caddie']))
	{
		if(isset($_SESSION['caddie'][$id]))//article deja présent
		{
			$_SESSION['caddieTot'] -= $_SESSION['caddie'][$id]['prix']*$_SESSION['caddie'][$id]['qte'];
			if($_SESSION['caddieTot']<0)
				$_SESSION['caddieTot'] = 0.00;
			unset($_SESSION['caddie'][$id]);
		}
	}
}

if(isset($_POST['id']))//si page apl
{
	if(isset($_POST['nom']) and isset($_POST['qte']) and isset($_POST['prix']))//si ajout
	{
		addpanier($_POST['id'],$_POST['nom'],$_POST['qte'],$_POST['prix']);
	}
	else//sinon supp
	{
		deletepanier($_POST['id']);
	}
}

?>