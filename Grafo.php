<?php

class Graph
{

  private $adj = array();

  private $vertex_data = array();

  private $totalEdges = 0;

  /**
   * 
   * Função que adiciona uma aresta, ligada a dois vértices V1 e V2
   * Caso a aresta já exista, nada acontecerá
   * Caso o vértice nao exista, o mesmo será criado  
   */
  public function addEdge($vertex1,$vertex2,$data=null)
  {

    if ($this->hasEdge($vertex1,$vertex2))
      return;

    if (!$this->hasVertex($vertex1))
      $this->addVertex($vertex1);
    if (!$this->hasVertex($vertex2))
      $this->addVertex($vertex2);


    $this->adj[$vertex1][$vertex2] = $data;
    $this->adj[$vertex2][$vertex1] = $data;

    $this->totalEdges += 2;

  }

  /**
   * 
   * Função que checa se existe uma aresta entra o vértice V1 e V2
   * Retorna verdadeiro ou falso de acordo com a condição
   */
  public function hasEdge($vertex1,$vertex2)
  {

    if (!$this->hasVertex($vertex1)) return false;
    if (!$this->hasVertex($vertex2)) return false;


    return array_key_exists($vertex2,$this->adj[$vertex1]);;
  }

  /**
   * Função que remove uma aresta do vértice V1 e V2
   * Retorna o dado que estava contido nela
   */
  public function removeEdge($vertex1,$vertex2)
  {

    if (!$this->hasEdge($vertex1,$vertex2))
      return null;

    $data = $this->adj[$vertex1][$vertex2];

    unset($this->adj[$vertex1][$vertex2]);
    unset($this->adj[$vertex2][$vertex1]);

    $this->totalEdges -= 2;

    return $data;
  }

  /**
   * Função que retorna os dados que estava associado a aresta dos vértices (V1, v2)
   */
  public function getEdgeData($vertex1,$vertex2)
  {

    if (!$hasEdge($vertex1,$vertex2))
      return null;

    return $this->adj[$vertex1][$vertex2]; 
  }

  /**
   * Função que adiciona um vértice e o conteudo contido nele
   */
  public function addVertex($vertex1,$data=null)
  {

    $this->vertex_data[$vertex1] = $data;
    $this->adj[$vertex1] = array();

  }

  /**
   * Função que checa se o vértice V1 existe
   */
  public function hasVertex($vertex1)
  {
    return array_key_exists($vertex1,$this->vertex_data);
  }

  /**
   * Função que retorna o conteúdo de um vértice, retorna nulo caso não exista
   */
  public function getVertexData($vertex1)
  {

    if (!array_key_exists($vertex1,$this->vertex_data))
      return null;

    return $this->vertex_data[$vertex1];
  }

  /**
   * Função que conta os vizinhos de um vértice
   */
  public function getVertexEdges($vertex1)
  {

    if (!$this->hasVertex($vertex1))
      return 0;

    return count($this->adj[$vertex1]);
  }


  /**
   * Função que retorna um array de vizinhos do vértice V1
   * Caso o vértice contenha conteúdo, retorna uma array associativa
   */
  public function getEdgeVertex($vertex1,$with_data=false)
  {

    if (!array_key_exists($vertex1,$this->adj))
      return array();

    $result = array();

    if ($with_data) {
      foreach( $this->adj[$vertex1] as $vertex2=>$data)
      {
        $result[$vertex2] = $data;
      }
    } else {

      foreach( $this->adj[$vertex1] as $vertex2=>$data)
      {
        array_push($result, $vertex2);
      }
    }

    return $result;
  }

  /**
   * Função que remove um vértice e retorna o conteúdo contido nele
   */
  public function removeVertex($vertex1)
  {

    if (!$this->hasVertex($vertex1)){

      return null;
    }

    foreach ($this->getEdgeVertex($vertex1) as $vertex2)
    {
      $this->removeEdge($vertex1,$vertex2);
    }


    $data = $this->vertex_data[$vertex1];

    unset($this->vertex_data[$vertex1]);
    unset($this->adj[$vertex1]);

    return $data;
  }
  
  /**
   * Função que retorna o número total de vértices daquele grafo
   */
  public function getTotalVertex()
  {

    return count($this->vertex_data);
  }

    /**
   * Função que retorna o número total de arestas daquele grafo
   */
  public function getTotalEdges()
  {
    return $this->totalEdges/2;
  }

  /**
   * Função que retorna uma lista dos vértices contidos no grafo
   */
  public function getVertexList($with_data=false)
  {
    $result = array();

    if ($with_data)
      foreach ($this->vertex_data as $vertex1=>$data)
        $result[$vertex1]=$data;
    else
      foreach ($this->vertex_data as $vertex1=>$data)
        array_push($result,$vertex1);

    return $result;
  }

  /**
   * Função que retorna uma lista das arestas contidas no grafo
   */
  public function getEdgeList($ordered=true)
  {
    $result_strings = array();
    foreach($this->vertex_data as $vertex1=>$v1_data)
    {
      foreach($this->adj[$vertex1] as $vertex2=>$v1v2_data)
      {
        if (!$ordered || ($vertex1 < $vertex2))
          array_push($result_strings, '('.$vertex1.','.$vertex2.')');
      }
    }
    return $result_strings;
  }

}
?>